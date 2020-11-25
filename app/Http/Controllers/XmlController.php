<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use App\fac_maestro_xml;
use App\xml_audit;
use App\GenEmpresaFel;

class XmlController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function firmaDocumento(request $request){
    	if (isset($request['pCia'])&&isset($request['pTipoDoc'])&&isset($request['pSerie'])&&isset($request['pDocto'])&&isset($request['pCorreo'])) {

    		$fel = GenEmpresaFel::where('gen_empresa_id', $request['pCia'])->first();
    		//echo $fel;
    		
    		$cia     = $request['pCia'];
    		$tipoDoc = $request['pTipoDoc'];
    		$serie   = $request['pSerie'];
    		$docto   = $request['pDocto'];
    		$correo  = $request['pCorreo'];
    		$codigo  = $request['pCia'].$request['pDocto'];

    		//echo $cia.' '.$tipoDoc.' '.$serie.' '.$docto.' '.$correo.' '.$codigo;

    		$fac_xml = fac_maestro_xml::where('gen_empresa_fel_id', $cia)
    		           ->where('tipodoc', $tipoDoc)
    		           ->where('serie', $serie)
    		           ->where('numdoc', $docto)
    		           ->select('id')
    		           ->first();

    		$stid = $fac_xml->xml;

            /*$conn = oci_connect('IMPEX', 'IMPEX', 'localhost:1521/XE');
            $stid = oci_parse($conn, "SELECT XML FROM FAC_MAESTRO_XML WHERE GEN_EMPRESA_FEL_ID=$cia AND TIPODOC="."'"."$tipoDoc"."'"." AND SERIE="."'".$serie."'"." AND numdoc=$docto");
            oci_execute($stid);

    		while ($fila = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS)) {
				foreach ($fila as $elemento) {
         			$resultado = ($elemento !== null ? htmlentities($elemento, ENT_QUOTES) : "");
				}	
			}*/

			$resultado = htmlentities($stid, ENT_QUOTES);
    		$resultado = str_replace("&lt;", "<", $resultado);
    		$resultado = str_replace("&gt;", ">", $resultado);
    		$resultado = str_replace("&quot;", "\"", $resultado);
    		$resultado = str_replace("&quot;", "\"", $resultado);

    		$firmado = $this->firma_inicial($cia, $tipoDoc, $serie, $docto, $fel->llave_firma, $fel->alias, 'N', $codigo, base64_encode($resultado));

    		if ($firmado == 'E') {
    			echo "E1";
    		}else{
    			$response = $this->firma_certificacion($fac_xml->id, $cia, $tipoDoc, $serie, $docto, $fel->nit, $fel->alias, $fel->llave_certifica, $codigo, $firmado, $correo);

    			echo $response;
    		}
    	}
    }

    public function firma_certificacion(int $maestro_id, int $cia, string $tipoDoc, string $serie, string $numDocto, string $nit_emisor, string $alias, string $llaveCertifica, int $codigo, $archivo_firmado, string $correo_cliente){

    	$service_url = 'https://certificador.feel.com.gt/fel/certificacion/v2/dte';
    	$curl = curl_init($service_url);
    	$jsonData =  ['nit_emisor'   => $nit_emisor,
		    		  'correo_copia' => $correo_cliente,
					  'xml_dte'      => $archivo_firmado];

    	$jsonDataEncoded = json_encode($jsonData);
    	//metodo que estamos usando podria ser: POST,GET,PUT,DELETE, pero estamos usando el POST
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($curl, CURLOPT_HEADER, true);
		//Se envian los headers que solicita el web services.
		curl_setopt($curl, CURLOPT_HTTPHEADER,
		 array("usuario: $alias","llave: $llaveCertifica","identificador: $codigo","Content-Type: application/json"));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$curl_response = curl_exec($curl);
		$cadenas = (string)$curl_response;
		$pos     = strpos($cadenas,'{');
		$rest    = substr($cadenas, $pos);
		$obj     = json_decode($rest);
		$fecha   = $obj->fecha;

		if ($obj->resultado == TRUE) {
			$xml = fac_maestro_xml::where('gen_empresa_fel_id', $cia)
			       ->where('tipodoc', $tipoDoc)
			       ->where('serie', $serie)
			       ->where('numdoc', $numDocto)
			       ->first();

			$xml->flag = 'F';
			$xml->sat_autorizacion   = $obj->uuid;
			$xml->sat_seriefel       = $obj->serie;
			$xml->sat_correlativofel = $obj->numero;
			//$xml->fecha_fel          = date_format($obj->fecha, '%d/%m/%Y H:i:s');
			//$xml->fecha_fel          = to_date(substr('$fecha',1,10)||' '||substr('$fecha',12,8),'YYYY/MM/DD HH24:mi:ss')
			$xml->sat_xml            = $obj->xml_certificado;
			$xml->save();
			return 'F';
		}else{
			$errores = $obj->cantidad_errores;
			for ($i = 0; $i < $errores; $i++) { 
				$error = new xml_audit();
				$error->fac_maestro_xml_id = $maestro_id;
				$error->mensaje            = $obj->descripcion_errores[$i]->{'mensaje_error'};
				$error->save();
			}

			$xml = fac_maestro_xml::where('gen_empresa_fel_id', $cia)
			       ->where('tipodoc', $tipoDoc)
			       ->where('serie', $serie)
			       ->where('numdoc', $numDocto)
			       ->first();

			$xml->flag = 'E';
			$xml->save();
			return 'E2';
		}
	}

    public function firma_inicial(int $cia, string $tipoDoc, string $serie, int $numDocto, string $llaveFirma, string $alias, string $es_anulacion, int $codigo, $archivo){
    	$registro_xml = fac_maestro_xml::where('gen_empresa_fel_id', $cia)
    	                ->where('tipodoc', $tipoDoc)
    	                ->where('serie', $serie)
    	                ->where('numdoc', $numDocto)
    	                ->first();

    	$service_url = 'https://signer-emisores.feel.com.gt/sign_solicitud_firmas/firma_xml';
    	$curl        = curl_init($service_url);
    	$jsonData    =  array(
						    'llave'        => $llaveFirma,
						    'archivo'      => $archivo,
						    'codigo'       => $codigo,
							'alias'        => $alias,
						    'es_anulacion' => $es_anulacion
						);

    	$jsonDataEncoded = json_encode($jsonData);
    	
    	curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$curl_response = curl_exec($curl);
		//descomentar para saber el error de E1
		//print_r($curl_response);
		$cadenas = (string)$curl_response;

		$pos     = strpos($cadenas,'{');
		$rest    = substr($cadenas, $pos);
		$obj     = json_decode($rest);
		$res     = $obj->resultado;

		try{
			if($res == TRUE){
				return $obj->archivo;
			}else{
				XmlController::Inserta_Errores($registro_xml->id, $obj->descripcion); 
			return 'E';
			}
		} catch (Exception $e) {
	    	echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}

		curl_close($curl);
	}

	
	public function Inserta_Errores(int $maestro_id, string $mensaje){
		
		$auditoria = new xml_audit();
		$auditoria->fac_maestro_xml_id = $maestro_id;
		$auditoria->mensaje            = $mensaje;
		$auditoria->save();

	}

    public function reenvio($xml_id){
    	//dd($xml_id);
    	$datos = DB::table('fac_maestro_xml fmx')
    	         ->join('gen_empresa_fels gef', 'fmx.gen_empresa_fel_id', 'gef.id')
    	         ->where('fmx.id', $xml_id)
    	         ->select('gef.gen_empresa_id', 'fmx.tipodoc', 'fmx.serie', 'fmx.numdoc', 'fmx.correo_electronico', 'fmx.nombre_factura', 'fmx.total_documento')
    	         ->first();

		//dd($datos);

		$error = '';

		if ($datos->tipodoc == 'F') {
			$crear_xml = 'PKG_FEL_GT.Pr_Fel_local';
			$parametros = [
	    		'pCia'     => $datos->gen_empresa_id,
	    		'pTipoDoc' => $datos->tipodoc,
	    		'pSerie'   => $datos->serie,
	    		'pDocto'   => $datos->numdoc,
	    		'pNombre'  => $datos->nombre_factura,
	    		'pCorreo'  => $datos->correo_electronico,
	    		'pTotal'   => $datos->total_documento,
	    		'pMensaje' => $error
	    	];
	    	$result = DB::executeProcedure($crear_xml, $parametros);
		}

    	if (empty($error)) {
    		$reenviar = 'PKG_FEL_GT.Fn_Certifica_Fel';
	    	$parametros = [
	    		'pCia'     => $datos->gen_empresa_id,
	    		'pTipoDoc' => $datos->tipodoc,
	    		'pSerie'   => $datos->serie,
	    		'pDocto'   => $datos->numdoc,
	    		'pCorreo'  => $datos->correo_electronico
	    	];

	    	$result = DB::executeFunction($reenviar, $parametros);

	    	if($result == 'F'){
	    		return Redirect::route('consulta_fel')->with('message','Documento Certificado con Exito !!!');
	    	}else{
	    		return Redirect::route('consulta_fel')->with('error','Error al certificar documento, verifique Bitacora');
	    	}
    	}else{
    		dd($result);
    	}
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\fac_maestro_xml;
use App\Fac_Maestro_Factura;
use App\xml_audit;
use App\GenEmpresaFel;
use DB;
use Response;
use SweetAlert;

class MaestroXmlController extends Controller
{
    //$listado = fac_maestro_xml::all();

    public function index(){
    	$listado = DB::table('gen_empresa_fels gef')
               ->join('fac_maestro_xml fmx', 'gef.id', 'fmx.gen_empresa_fel_id')
               ->join('GEN_TIPO_DOCUMENTO gtd', 'fmx.tipodoc', 'gtd.codtipo')
               ->select('gef.nombre_comercial', 'fmx.serie', 'fmx.numdoc', 'fmx.fecha_emision', 'fmx.id', 'fmx.flag', 'gtd.descripcion as tipodocumento_descripcion', 'fmx.nombre_factura', 'fmx.correo_electronico', 'fmx.total_documento')
               ->orderBy('fmx.id', 'DESC')
               ->get();

	    return view('consultas.index', compact('listado'));
    }

  public function get_aut(){
    $id = $_POST['id'];
    $autoriza = fac_maestro_xml::findOrFail($id);
    return Response::json($autoriza);
  }

  public function get_err(){
    $id = $_POST['id'];
    $errores = xml_audit::where('fac_maestro_xml_id', $id)->get();
    return Response::json($errores);
  }

  public function get_header(){
    $id = $_POST['id'];
    $header = DB::table('fac_maestro_xml fmx')
              ->join('gen_empresa_fels gef', 'fmx.gen_empresa_fel_id', 'gef.id')
              ->join('gen_tipo_documento gtd', 'fmx.tipodoc', 'gtd.codtipo')
              ->where('fmx.id', $id)
              ->select('fmx.id', 'gef.nombre_comercial', 'gtd.descripcion as tipodocumento_descripcion', 
                'fmx.serie', 'fmx.numdoc', 'fmx.fecha_emision', 'fmx.nombre_factura', 'fmx.correo_electronico',
                'fmx.total_documento')
              ->first();
    return Response::json($header);
  }

  public function set_mail_account(){
    $id = $_POST['id'];
    $email = $_POST['email'];

    $registro = fac_maestro_xml::findOrFail($id);
    $registro->correo_electronico = $email;
    $registro->save();

    $empresa = GenEmpresaFel::findOrFail($registro->gen_empresa_fel_id);

    \DB::table('fac_maestro_factura')->where(['codemp' => $empresa->gen_empresa_id, 'tipodoc' => $registro->tipodoc, 'serie' => $registro->serie, 'numdoc' => $registro->numdoc])->update(['email_fel' => $email]);

    return Response::json('Correo actualizado con exito');
    //return Response::json($registro->tipodoc.' '.$registro->serie.' '.$registro->numdoc);
  }
  
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\fac_maestro_xml;
use App\xml_audit;
use DB;
use Response;

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
  
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\GenMunicipio;

class GenMunicipioController extends Controller
{
    public function get_municipio(){
    	$depto_id = $_POST['depto_id'];

    	$municipios = GenMunicipio::where('codepto_guate', $depto_id)->get();
    	return Response::json($municipios);
    }
}

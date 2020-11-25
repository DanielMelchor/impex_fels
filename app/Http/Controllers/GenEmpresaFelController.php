<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GenEmpresaFel;
use App\GenEmpresa;
use App\GenDeptosGuate;
use App\GenMunicipio;
use Session;

class GenEmpresaFelController extends Controller
{
    public function index(){
    	$empresas = GenEmpresaFel::all();
    	$listaEmpresas = GenEmpresa::all();
        $departamentos = GenDeptosGuate::all();
    	return view('empresas.index', compact('empresas', 'listaEmpresas', 'departamentos'));
    }

    public function store(Request $request){
    	$validData = $request->validate([
            'pais'               => 'required',
            'gen_empresa_id'     => 'required',
            'nit'                => 'required',
            'razon_social'       => 'required',
            'nombre_comercial'   => 'required',
            'direccion'          => 'required',
            'depto_id'           => 'required',
            'munic_id'           => 'required',
            'codigo_postal'      => 'required',
            'afiliacion_iva'     => 'required',
            'correo_electronico' => 'required',
            'alias'              => 'required',
            'llave_firma'        => 'required',
            'llave_certifica'    => 'required',
            'formato'            => 'required'
        ]);

        $empresa = new GenEmpresaFel();
        $empresa->pais               = $validData['pais'];
        $empresa->gen_empresa_id     = $validData['gen_empresa_id'];
        $empresa->nit                = $validData['nit'];
        $empresa->razon_social       = $validData['razon_social'];
        $empresa->nombre_comercial   = $validData['nombre_comercial'];
        $empresa->direccion          = $validData['direccion'];
        $empresa->depto_id           = $validData['depto_id'];
        $empresa->munic_id           = $validData['munic_id'];
        $empresa->codigo_postal      = $validData['codigo_postal'];
        $empresa->afiliacion_iva     = $validData['afiliacion_iva'];
        $empresa->correo_electronico = $validData['correo_electronico'];
        $empresa->alias              = $validData['alias'];
        $empresa->llave_firma        = $validData['llave_firma'];
        $empresa->llave_certifica    = $validData['llave_certifica'];
        $empresa->formato            = $validData['formato'];
        $empresa->save();

        Session::flash('success', 'FEL Guardado con exito !!!' );
        return redirect(route('empresas'));

    }

    public function edit($id){
        $empresa = GenEmpresaFel::findOrFail($id);
        $listaEmpresas = GenEmpresa::all();
        $departamentos = GenDeptosGuate::all();

        //dd($listaEmpresas);

        return view('empresas.edit', compact('empresa', 'listaEmpresas', 'departamentos'));
    }

    public function update($id, request $request){
        $validData = $request->validate([
            'pais'               => 'required',
            'gen_empresa_id'     => 'required',
            'nit'                => 'required',
            'razon_social'       => 'required',
            'nombre_comercial'   => 'required',
            'direccion'          => 'required',
            'depto_id'           => 'required',
            'munic_id'           => 'required',
            'codigo_postal'      => 'required',
            'afiliacion_iva'     => 'required',
            'correo_electronico' => 'required',
            'alias'              => 'required',
            'llave_firma'        => 'required',
            'llave_certifica'    => 'required',
            'formato'            => 'required'
        ]);

        $empresa = GenEmpresaFel::findOrFail($id);
        $empresa->pais               = $validData['pais'];
        $empresa->gen_empresa_id     = $validData['gen_empresa_id'];
        $empresa->nit                = $validData['nit'];
        $empresa->razon_social       = $validData['razon_social'];
        $empresa->nombre_comercial   = $validData['nombre_comercial'];
        $empresa->direccion          = $validData['direccion'];
        $empresa->depto_id           = $validData['depto_id'];
        $empresa->munic_id           = $validData['munic_id'];
        $empresa->codigo_postal      = $validData['codigo_postal'];
        $empresa->afiliacion_iva     = $validData['afiliacion_iva'];
        $empresa->correo_electronico = $validData['correo_electronico'];
        $empresa->alias              = $validData['alias'];
        $empresa->llave_firma        = $validData['llave_firma'];
        $empresa->llave_certifica    = $validData['llave_certifica'];
        $empresa->formato            = $validData['formato'];
        $empresa->save();

        Session::flash('success', 'FEL Guardado con exito !!!' );
        return redirect(route('empresas'));        
    }
}

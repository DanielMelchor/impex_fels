@extends('admin.layout')
@section('css')
@endsection
@section('titulo')
    Empresa
@endsection
@section('subtitulo')
    Edición
@endsection
@section('contenido')
    <div class="row">
        <div class="col">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <div class="modal-content">
        <form role="form" method="POST" action="{{ route('actualiza_empresa', $empresa->id) }}">
            @csrf
            <div class="card-navy">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2 offset-md-10" style="text-align: right;">
                            @can('actualizar-empresa')
                            <button type="submit" class="btn btn-sm btn-success" title="Grabar">
                                <i class="fas fa-save"></i>
                            </button>
                            @endcan
                            <a href="{{ route('empresas') }}" class="btn btn-sm btn-danger" title="Regresar a lista de Pacientes"><i class="fas fa-sign-out-alt"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">País</span>
                                </div>
                                <input type="text" id="pais" name="pais" class="form-control" value="{{ $empresa->pais }}" autofocus required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 input-group col-md-10 offset-md-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" for="religion">Empresa</span>
                                </div>
                                <select class="custom-select select2 select2bs4" id="gen_empresa_id" name="gen_empresa_id" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($listaEmpresas as $le)
                                        <option value="{{ $le->codemp}}" @if($le->codemp == $empresa->gen_empresa_id) selected @endif>{{ $le->nomemp}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">N.I.T.</span>
                                </div>
                                <input type="text" id="nit" name="nit" class="form-control" value="{{ $empresa->nit }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Razón Social</span>
                                </div>
                                <input type="text" id="razon_social" name="razon_social" class="form-control" value="{{ $empresa->razon_social }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Nombre Comercial</span>
                                </div>
                                <input type="text" id="nombre_comercial" name="nombre_comercial" class="form-control" value="{{ $empresa->nombre_comercial }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Dirección</span>
                                </div>
                                <input type="text" id="direccion" name="direccion" class="form-control" value="{{ $empresa->direccion }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 input-group col-md-10 offset-md-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" for="depto_id">Departamento</span>
                            </div>
                            <select class="custom-select select2 select2bs4" id="depto_id" name="depto_id" onchange="fn_llenaMunicipio(); return false;">
                                <option value="">Seleccionar...</option>
                                @foreach($departamentos as $d)
                                    <option value="{{ $d->codepto_guate }}" @if($d->codepto_guate == $empresa->depto_id) selected @endif>{{ $d->nomdepto_guate }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="municipio_id" id="municipio_id" value="{{ $empresa->munic_id}}">
                    <div class="row">
                        <div class="mb-3 input-group col-md-10 offset-md-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" for="munic_id">Municipio</span>
                            </div>
                            <select class="custom-select select2 select2bs4" id="munic_id" name="munic_id">
                                <option value="">Seleccionar...</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Código Postal</span>
                                </div>
                                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" value="{{ $empresa->codigo_postal }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 input-group col-md-10 offset-md-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" for="afiliacion_iva">Afiliación I.V.A.</span>
                                </div>
                                <select class="custom-select select2 select2bs4" id="afiliacion_iva" name="afiliacion_iva" required>
                                    <option value="G" selected>General</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">correo electronico</span>
                                </div>
                                <input type="email" id="correo_electronico" name="correo_electronico" class="form-control" value="{{ $empresa->correo_electronico }}" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Alias</span>
                                </div>
                                <input type="text" id="alias" name="alias" class="form-control" value="{{ $empresa->alias }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Firma</span>
                                </div>
                                <input type="text" id="llave_firma" name="llave_firma" class="form-control" value="{{ $empresa->llave_firma }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Certificación</span>
                                </div>
                                <input type="text" id="llave_certifica" name="llave_certifica" class="form-control" value="{{ $empresa->llave_certifica }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
<script type="text/javascript">
    function fn_llenaMunicipio(){
        var depto_id = document.getElementById('depto_id').value;
        var municipio_id = document.getElementById('municipio_id').value;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('trae_municipios_x_depto') }}",
            method: "POST",
            data: {depto_id: depto_id
                  },
            success: function(response){
                if (response != 0) {
                    var html = '<option value="" >Seleccionar...</option>';
                    for (var i = 0; i < response.length; i++) {
                        if (response[i]['cod_municipio'] == municipio_id) {
                            html += '<option value="'+response[i]['cod_municipio']+'" selected>'+response[i]['nom_municipio']+'</option>';
                        }else{
                            html += '<option value="'+response[i]['cod_municipio']+'">'+response[i]['nom_municipio']+'</option>';
                        }
                    }
                    $('#munic_id').html(html);
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    window.onload = function() {
        fn_llenaMunicipio();
    }
</script>
@endsection
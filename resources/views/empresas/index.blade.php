@extends('admin.layout')
@section('css')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('titulo')
	Empresas
@endsection
@section('subtitulo')
	Listado
@endsection
@section('contenido')
	<div class="card card-navy">
		<div class="card-header text-center">
			<div class="row">
				<div class="col-md-2 offset-md-10" style="text-align: right;">
					@can('crear-empresa')
					<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#empresaModal">
				  		<i class="fas fa-plus-circle"></i>
					</button>
					@endcan
				</div>
			</div>
		</div>
		<div class="card-body">
			<table class="table table-sm table-striped table-hover text-center">
				<thead>
					<tr>
						<th>Pais</th>
						<th>Razón Social</th>
						<th>Direccion</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					@foreach($empresas as $e)
						<tr>
							@if($e->pais == 'GT')
								<td>Guatemala</td>
							@else
								<td>Costa Rica</td>
							@endif
							<td>{{ $e->razon_social}}</td>
							<td>{{ $e->direccion}}</td>
							<td>
								@can('editar-empresa')
								<a href="{{ route('edit_empresa', $e->id) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
								@endcan
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="empresaModal" tabindex="-1" role="dialog" aria-labelledby="empresaModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-lg" role="document">
	    	<div class="modal-content">
	    		<form role="form" method="POST" action="{{ route('graba_empresa') }}">
	    			@csrf
			      	<div class="modal-body">
			        	<div class="card-navy">
			        		<div class="card-header">
			        			<div class="row">
			        				<div class="col-md-9">
			        					<h6>Nueva Empresa</h6>
			        				</div>
			        				<div class="col-md-3" style="text-align: right;">
			        					<button type="submit" class="btn btn-sm btn-success" title="Grabar"><i class="fas fa-save"></i></button>
			        					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i></button>
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
										  	<input type="text" id="pais" name="pais" class="form-control" autofocus required>
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
                                                	<option value="{{ $le->codemp}}">{{ $le->nomemp}}</option>
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
										  	<input type="text" id="nit" name="nit" class="form-control" required>
										</div>
			        				</div>
			        			</div>
			        			<div class="row">
			        				<div class="col-md-10 offset-md-1 mb-3">
			        					<div class="input-group">
									  		<div class="input-group-prepend">
										    	<span class="input-group-text" id="">Razón Social</span>
										  	</div>
										  	<input type="text" id="razon_social" name="razon_social" class="form-control" required>
										</div>
			        				</div>
			        			</div>
			        			<div class="row">
			        				<div class="col-md-10 offset-md-1 mb-3">
			        					<div class="input-group">
									  		<div class="input-group-prepend">
										    	<span class="input-group-text" id="">Nombre Comercial</span>
										  	</div>
										  	<input type="text" id="nombre_comercial" name="nombre_comercial" class="form-control" required>
										</div>
			        				</div>
			        			</div>
			        			<div class="row">
			        				<div class="col-md-10 offset-md-1 mb-3">
			        					<div class="input-group">
									  		<div class="input-group-prepend">
										    	<span class="input-group-text" id="">Dirección</span>
										  	</div>
										  	<input type="text" id="direccion" name="direccion" class="form-control" required>
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
                                            	<option value="{{ $d->codepto_guate }}">{{ $d->nomdepto_guate }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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
										  	<input type="text" id="codigo_postal" name="codigo_postal" class="form-control" required>
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
                                                <option value="G">General</option>
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
										  	<input type="email" id="correo_electronico" name="correo_electronico" class="form-control" required>
										</div>
			        				</div>
			        			</div>
			        			<div class="row">
			        				<div class="col-md-10 offset-md-1 mb-3">
			        					<div class="input-group">
									  		<div class="input-group-prepend">
										    	<span class="input-group-text" id="">Formato</span>
										  	</div>
										  	<input type="number" id="formato" name="formato" class="form-control" required>
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
										  	<input type="text" id="alias" name="alias" class="form-control" required>
										</div>
			        				</div>
			        			</div>
			        			<div class="row">
			        				<div class="col-md-10 offset-md-1 mb-3">
			        					<div class="input-group">
									  		<div class="input-group-prepend">
										    	<span class="input-group-text" id="">Firma</span>
										  	</div>
										  	<input type="text" id="llave_firma" name="llave_firma" class="form-control" required>
										</div>
			        				</div>
			        			</div>
			        			<div class="row">
			        				<div class="col-md-10 offset-md-1 mb-3">
			        					<div class="input-group">
									  		<div class="input-group-prepend">
										    	<span class="input-group-text" id="">Certificación</span>
										  	</div>
										  	<input type="text" id="llave_certifica" name="llave_certifica" class="form-control" required>
										</div>
			        				</div>
			        			</div>
			        		</div>
			        	</div>
			      	</div>
		      	</form>
    		</div>
	  	</div>
	</div>
@endsection
@section('js')
<script type="text/javascript">
	function fn_llenaMunicipio(){
		var depto_id = document.getElementById('depto_id').value;
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
                    	html += '<option value="'+response[i]['cod_municipio']+'" >'+response[i]['nom_municipio']+'</option>';
                    }
                    $('#munic_id').html(html);
                }
            },
            error: function(error){
                console.log(error);
            }
        });
	}
</script>
@endsection
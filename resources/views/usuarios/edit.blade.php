@extends('admin.layout')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/multi-select/css/multi-select.css') }}">
@endsection
@section('titulo')
	Edición de usuario
@endsection
@section('contenido')
	<div class="content-fluid">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<form role="form" method="POST" action="{{ route('actualizar_usuario', $usuario->id) }}">
					@csrf
					{{ csrf_field() }}
					<div class="card card-navy">
						<div class="card-header">
	        				<div class="row">
	        					<div class="col-md-8">
	        						<h6>Edición de Usuario</h6>
	        					</div>
	        					<div class="col-md-4" style="text-align: right;">
	        						@can('actualizar-usuario')
	        						<button type="submit" class="btn btn-success btn-sm" title="Guardar">
	        							<i class="fas fa-save"></i>
	        						</button>
	        						@endcan
        							<a href="{{ route('usuarios') }}" class="btn btn-danger btn-sm" title="Rregresar a lista de Usuarios"><i class="fas fa-sign-out-alt"></i></a>
	        					</div>
	        				</div>
	        			</div>
	        			<div class="card-body">
							<div class="row">
								<div class="input-group col-md-4 offset-md-1 mb-1">
							  		<div class="input-group-prepend">
								    	<span class="input-group-text" id="basic-addon1">Usuario</span>
								  	</div>
								  	<input type="text" class="form-control" placeholder="Usuario" aria-label="Username" aria-describedby="addon-wrapping" id="username" name="username" value="{{ $usuario->username }}" autofocus required>
								</div>
								<div class="input-group col-md-6 mb-1">
							  		<div class="input-group-prepend">
								    	<span class="input-group-text" id="basic-addon1">Nombre</span>
								  	</div>
								  	<input type="text" class="form-control" placeholder="Nombre de usuario" aria-label="name" aria-describedby="addon-wrapping" id="name" name="name" value="{{ $usuario->name }}" required>
								</div>
							</div>
			        		<hr>
			        		<div class="row">
			        			<div class="col-md-5 offset-md-3">
			        				<select id='callbacks' name="callbacks[]" multiple='multiple'>
										@foreach($roles as $r)
											<option value='{{ $r->id}}'>{{ $r->name }}</option>
										@endforeach
									</select>	
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
	<script src="{{ asset('assets/multi-select/js/jquery.multi-select.js') }}"></script>
	<script type="text/javascript">
		$('#callbacks').multiSelect({
			selectableHeader: "<div class='custom-header text-center'>Roles</div>",
			selectionHeader: "<div class='custom-header text-center'>Otorgados</div>",
	      afterSelect: function(values){
	        //alert("Select value: "+values);
	      },
	      afterDeselect: function(values){
	        //alert("Deselect value: "+values);
	      }
	    });
	    var x = [];
	    @foreach ($roles_asignados as $ra)
	    	x.push("{{ $ra['role_id'] }}");
	    @endforeach
	    $('#callbacks').multiSelect('select', x);
	</script>
@endsection
@extends('admin.layout')
@section('titulo')
	Edición de Permiso
@endsection
@section('contenido')
	<div class="content-fluid">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<form role="form" method="POST" action="{{ route('actualizar_permiso', $permiso->id) }}">
					@csrf
					{{ csrf_field() }}
					<div class="card card-navy">
						<div class="card-header">
	        				<div class="row">
	        					<div class="col-md-8">
	        						<h6>Edición de Permiso</h6>
	        					</div>
	        					<div class="col-md-4" style="text-align: right;">
	        						@can('actualizar-permiso')
	        						<button type="submit" class="btn btn-success btn-sm" title="Guardar">
	        							<i class="fas fa-save"></i>
	        						</button>
	        						@endcan
        							<a href="{{ route('permisos') }}" class="btn btn-danger btn-sm" title="Rregresar a lista de familias"><i class="fas fa-sign-out-alt"></i></a>
	        					</div>
	        				</div>
	        			</div>
	        			<div class="card-body">
	        				<div class="row text-center">
			        			<div class="col-md-10 offset-md-1">
			        				<label for="name">Nombre</label>
			        			</div>
			        		</div>
	        				<div class="row text-center">
			        			<div class="input-group col-md-10 offset-md-1">
			        				<input type="text" class="form-control" placeholder="nombre de permiso" aria-label="Username" aria-describedby="addon-wrapping" id="name" name="name" value="{{ $permiso->name }}" autofocus required>
			        			</div>
			        		</div>
	        			</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
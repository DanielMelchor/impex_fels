@extends('admin.layout')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/multi-select/css/multi-select.css') }}">
@endsection
@section('titulo')
	Edición de Role
@endsection
@section('contenido')
	<div class="content-fluid">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<form role="form" method="POST" action="{{ route('actualizar_role', $role->id) }}">
					@csrf
					{{ csrf_field() }}
					<div class="card card-navy">
						<div class="card-header">
	        				<div class="row">
	        					<div class="col-md-8">
	        						<h6>Edición de role</h6>
	        					</div>
	        					<div class="col-md-4" style="text-align: right;">
	        						@can('actualizar-role')
	        						<button type="submit" class="btn btn-success btn-sm" title="Guardar">
	        							<i class="fas fa-save"></i>
	        						</button>
	        						@endcan
        							<a href="{{ route('roles') }}" class="btn btn-danger btn-sm" title="Rregresar a lista de roles"><i class="fas fa-sign-out-alt"></i></a>
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
			        				<input type="text" class="form-control" placeholder="nombre de role" aria-label="Username" aria-describedby="addon-wrapping" id="name" name="name" value="{{ $role->name }}" autofocus required>
			        			</div>
			        		</div>
			        		<br>
			        		<div class="row">
			        			<div class="col-md-5 offset-md-3">
			        				<select id='callbacks' name="callbacks[]" multiple='multiple'>
										@foreach($permisos as $p)
											<option value='{{ $p->id}}'>{{ $p->name }}</option>
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
			selectableHeader: "<div class='custom-header text-center'>Permisos</div>",
			selectionHeader: "<div class='custom-header text-center'>Otorgados</div>",
	      afterSelect: function(values){
	        //alert("Select value: "+values);
	      },
	      afterDeselect: function(values){
	        //alert("Deselect value: "+values);
	      }
	    });
	    var x = [];
	    @foreach ($permisos_x_role as $pr)
	    	x.push("{{ $pr['permission_id'] }}");
	    @endforeach
	    $('#callbacks').multiSelect('select', x);
	</script>
@endsection
@extends('admin.layout')
@section('css')
	<link rel="stylesheet" href="{{asset('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/select2/css/select2.min.css')}}">
  	<link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('titulo')
	Listado de Usuarios
@endsection
@section('contenido')
	@if (session('success'))
	    <div class="col-sm-12">
	        <div class="alert alert-success alert-dismissible fade show" role="alert">
	            {{ session('success') }}
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	            	<span aria-hidden="true">&times;</span>
                </button>
	        </div>
	    </div>
	@endif
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
    <div class="card card-navy">
		<div class="card-header text-center">
			<div class="row">
				<div class="col-md-2 offset-md-10" style="text-align: right;">
					@can('crear-usuario')
					<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#usuarioModal">
				  		<i class="fas fa-plus-circle"></i>
					</button>
					@endcan
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row text-center">
				<div class="col-md-5 offset-md-4">
					<table id="proveedores" class="table table-sm table-striped table-hover" style="width:100%">
	          			<thead>
							<tr>
								<th>Usuario</th>
								<th>Nombre</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach($usuarios as $u)
								<tr>
									<td>{{ $u->username }}</td>
									<td>{{ $u->name }}</td>
									<td style="text-align: right;">
										@can('editar-usuario')
										<a href="{{ route('editar_usuario', $u->id) }}" class="btn btn-sm btn-warning" title="Editar">
											<i class="fa fa-edit"></i>
										</a>
										@endcan
										@can('reiniciar-contraseña')
										<a href="{{ route('actualizar_pass', $u->id) }}" class="btn btn-sm btn-primary" title="Re iniciar contraseña">
											<i class="fa fa-edit"></i>
										</a>
										@endcan
									</td>
								</tr>
							@endforeach
						</tbody>
	          		</table>
				</div>
			</div>
		</div>
	</div>
	@section('js')
		<!--<script src="{{asset('assets/adminlte/plugins/jquery/jquery.min.js')}}"></script> -->
		<!-- Bootstrap 4 -->
		<script src="{{asset('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<!-- DataTables -->
		<script src="{{asset('assets/adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>
		<script src="{{asset('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
		<script src="{{ asset('assets/adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
		<script>
	  		//========================================================================
			// inicializar librerias
			//========================================================================
			$(function () {
				$('.select2').select2()
				$('.select2bs4').select2({
			      theme: 'bootstrap4'
			    })
			});

	  		$(function () {
			    $('#proveedores').DataTable({
			      "paging": true,
			      "lengthChange": false,
			      "searching": true,
			      "ordering": true,
			      "info": true,
			      "autoWidth": false,
			      language: {
				        "sProcessing":     "Procesando...",
	                	"sLengthMenu":     "Mostrar _MENU_ registros",
	                	"sZeroRecords":    "No se encontraron resultados",
	                	"sEmptyTable":     "Ningún dato disponible en esta tabla =(",
	                	"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	                	"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	                	"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	                	"sInfoPostFix":    "",
	                	"sSearch":         "Buscar:",
	                	"sUrl":            "",
	                	"sInfoThousands":  ",",
	                	"sLoadingRecords": "Cargando...",
	                	"oPaginate": {
	                    				"sFirst":    "Primero",
	                    				"sLast":     "Último",
	                    				"sNext":     "Siguiente",
	                    				"sPrevious": "Anterior"
	            					}
				    },
				    dom: 'Bfrtip'
			    });
		  	});
		</script>
	@endsection
	<!-- Modal -->
	<div class="modal fade" id="usuarioModal" role="dialog" aria-labelledby="usuarioModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      		<form role="form" method="POST" action="{{ route('grabar_usuario') }}">
	      			@csrf
	      			{{ csrf_field() }}
		      		<div class="modal-body">
		        		<div class="card card-navy">
		        			<div class="card-header">
		        				<h5>Nuevo Usuario</h5>
		        			</div>
		        			<div class="card-body">
		        				<div class="row">
		        					<div class="input-group col-md-10 offset-md-1 mb-1">
								  		<div class="input-group-prepend">
									    	<span class="input-group-text" id="basic-addon1">Usuario</span>
									  	</div>
									  	<input type="text" class="form-control" placeholder="Usuario" aria-label="Username" aria-describedby="addon-wrapping" id="username" name="username" value="{{ old('username')}}" autofocus required>
									</div>
		        				</div>
		        				<div class="row">
		        					<div class="input-group col-md-10 offset-md-1 mb-1">
								  		<div class="input-group-prepend">
									    	<span class="input-group-text" id="sname">Nombre</span>
									  	</div>
									  	<input type="text" class="form-control" placeholder="Nombre de usuario" aria-label="Username" aria-describedby="addon-wrapping" id="name" name="name" value="{{ old('name')}}">
									</div>
		        				</div>
		        			</div>
		        			<div class="card-footer">
		        				<div class="row">
		        					<div class="col-md-5 offset-md-7" style="text-align: right;">
		        						<button type="submit" class="btn btn-success btn-sm" title="Grabar"> <i class="fas fa-save"></i> Guardar</button>
		        						<button type="button" class="btn btn-danger btn-sm" title="Regresar a lista de Usuarios" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Salir</button>	
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
		$('#usuarioModal').on('shown.bs.modal', function() {
		  $('#username').focus();
		});
	</script>
@endsection
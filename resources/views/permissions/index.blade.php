@extends('admin.layout')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('titulo')
	Listado de Permisos
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
	<div class="card card-navy">
		<div class="card-header text-center">
			<div class="row">
				<div class="col-md-2 offset-md-10" style="text-align: right;">
					@can('crear-permiso')
					<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#permisoModal">
				  		<i class="fas fa-plus-circle"></i>
					</button>
					@endcan
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row text-center">
				<div class="col-md-5 offset-md-4">
					<table id="tblpermisos" class="table table-sm table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>Permiso</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach($permisos as $p)
							<tr>
								<td>{{ $p->name }}</td>
								<td>
									@can('editar-permiso')
									<a href="{{ route('editar_permiso', $p->id) }}" class="btn btn-sm btn-warning" title="Editar Permiso">
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
	<!-- Modal -->
	<div class="modal fade" id="permisoModal" tabindex="-1" role="dialog" aria-labelledby="permisoModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      		<form role="form" method="POST" action="{{ route('grabar_permiso') }}">
	      			@csrf
	      			{{ csrf_field() }}
		      		<div class="modal-body">
		        		<div class="card card-navy">
		        			<div class="card-header">
			        			<div class="row">
			        				<div class="col-md-8">
			        					<h6>Nuevo Permiso</h6>
			        				</div>
			        				<div class="col-md-4" style="text-align: right;">
			        					<button type="submit" class="btn btn-success btn-sm" title="Grabar"><i class="fas fa-save"></i></button>
		        						<button type="button" class="btn btn-danger btn-sm" title="Regresar a lista de familias" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i></button>
			        				</div>
			        			</div>		        				
		        			</div>
		        			<div class="card-body">
		        				<br>
		        				<div class="row text-center">
		        					<div class="col-md-10 offset-md-1">
		        						<label for="name">Nombre</label>
		        					</div>
		        				</div>
		        				<div class="row text-center">
				        			<div class="input-group col-md-10 offset-md-1">
				        				<input type="text" class="form-control" placeholder="nombre de permiso" aria-label="name" aria-describedby="addon-wrapping" id="name" name="name" required>
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
	<script src="{{ asset('assets/adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
	<script type="text/javascript">
		$('#permisoModal').on('shown.bs.modal', function() {
		  $('#name').focus();
		});

		$(function () {
	        $('#tblpermisos').DataTable({
	          "paging": true,
	          "lengthChange": false,
	          "searching": true,
	          "ordering": true,
	          "info": true,
	          "autoWidth": true,
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
	            dom: 'Bfrtip',
	        });
    });
	</script>
@endsection
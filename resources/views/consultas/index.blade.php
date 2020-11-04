@extends('admin.layout')
@section('css')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endsection
@section('titulo')
	Empresas
@endsection
@section('subtitulo')
	Listado
@endsection
@section('contenido')
	@if(Session::has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" arial-label="Close"><label aria-hidden="true">x</label>
            </button>
            {{ Session::get('message') }}  
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
				<!--<div class="col-md-2 offset-md-10" style="text-align: right;">
					<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#empresaModal">
				  		<i class="fas fa-plus-circle"></i>
					</button>
				</div>-->
			</div>
		</div>
		<div class="card-body">
			<table id="fels" class="table table-sm table-striped table-hover text-center">
				<thead>
					<tr>
						<th>Empresa</th>
						<th>Tipo Documento</th>
						<th>Serie</th>
						<th>Documento</th>
						<th>Fecha Emision</th>
						<th>Nombre</th>
						<th>Correo</th>
						<th>Total</th>
						<th>Estado</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					@foreach($listado as $l)
						<tr @if ($l->flag == 'E') then style="background: #FEB3B3;" @elseif ($l->flag == 'P') then style="background: #ECFFDC;" @endif>
							<td>{{ $l->nombre_comercial }}</td>
							<td>{{ $l->tipodocumento_descripcion }}</td>
							<td>{{ $l->serie }}</td>
							<td>{{ $l->numdoc }}</td>
							<td>{{ \Carbon\Carbon::parse($l->fecha_emision)->format('d/m/Y') }}</td>
							<td>{{ $l->nombre_factura }}</td>
							<td>{{ $l->correo_electronico}}</td>
							<td>{{ $l->total_documento }}</td>
							<td>
								@switch($l->flag)
								@case('P')
									<p>Pendiente</p>
									@break
								@case('F')
									<p>Finalizado</p>
									@break
								@default
									<p>Error</p>
									@break
								@endswitch
							</td>
							<td style="text-align: right;">
								@if($l->flag == 'P' || $l->flag == 'E')
									@can('ver-errores','renviar_fel')
									<a href="{{ route('reenviar_documento', $l->id) }}" class="btn btn-sm btn-outline-success" title="Certificar">
										<i class="fas fa-paper-plane"></i>
									</a>
									@endcan
								@endif
								@if($l->flag == 'E')
									@can('ver-errores')
									<a href="#" class="btn btn-sm btn-warning" onclick="fn_mostrarerror({{$l->id}}); return false;">
										<i class="fas fa-eye"></i>
									</a>
									@endcan
								@endif
								@if($l->flag == 'F')
									@can('ver-autorizacion')
									<a href="#" class="btn btn-sm btn-warning" onclick="fn_mostrardetalle({{$l->id}}); return false;">
										<i class="fas fa-eye"></i>
									</a>
									@endcan
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<!-- Modal Autorizacion -->
	<div class="modal fade" id="ShowAutorizacionModal" tabindex="-1" role="dialog" aria-labelledby="empresaModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-md modal-dialog-centered" role="document">
	    	<div class="modal-content">
	    		<div class="card border-success">
	    			<div class="card-header">
	    				<div class="row">
	    					<div class="col-md-2">
	    						<img src="{{ asset('assets/logos/logo-impex-blue.png')}}" style="height: 25px;">
	    					</div>
	    					<div class="col-md-8 text-center">
	    						<h5>Autorización SAT</h5>
	    					</div>
	    					<div class="col-md-2" style="text-align: right;">
	    						<button type="button" class="btn btn-danger" data-dismiss="modal" title="Cerrar"><i class="fas fa-sign-out-alt"></i></button>
	    					</div>
	    				</div>
	    			</div>
	    			<div class="card-body text-secondary">
	    				<table id="fels_aut" class="table table-sm table-striped">
	    					<tbody></tbody>
	    				</table>
	    			</div>
	    		</div>
    		</div>
	  	</div>
	</div>
	<!-- /Modal Autorizacion -->
	<!-- Modal Error -->
	<div class="modal fade" id="ShowErrorModal" tabindex="-1" role="dialog" aria-labelledby="empresaModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-md modal-dialog-centered" role="document">
	    	<div class="modal-content">
	    		<div class="card border-success">
	    			<div class="card-header">
	    				<div class="row">
	    					<div class="col-md-2">
	    						<img src="{{ asset('assets/logos/logo-impex-blue.png')}}" style="height: 25px;">
	    					</div>
	    					<div class="col-md-8 text-center">
	    						<h5>Errores</h5>
	    					</div>
	    					<div class="col-md-2" style="text-align: right;">
	    						<button type="button" class="btn btn-danger" data-dismiss="modal" title="Cerrar"><i class="fas fa-sign-out-alt"></i></button>
	    					</div>
	    				</div>
	    			</div>
	    			<div class="card-body text-secondary">
	    				<table id="fels_err" class="table table-sm table-striped">
	    					<tbody></tbody>
	    				</table>
	    			</div>
	    		</div>
    		</div>
	  	</div>
	</div>
	<!-- /Modal Error -->
@endsection
@section('js')
	<script src="{{asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <script>
      $(function () {
        $('#fels').DataTable({
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

      function fn_mostrardetalle(id){
      	$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        url: "{{ route('trae_detalle_autoriza') }}",
	        method: "POST",
	        data: {id: id
	              },
	        success: function(response){
                var html = '';
                html += '<tr>'
                html += '<th>'
                html += 'Autorización'
                html += '<th>'
                html += '<td>'
                html += response['sat_autorizacion']
                html += '</td>'
                html += '</tr>'

                html += '<tr>'
                html += '<th>'
                html += 'Serie'
                html += '<th>'
                html += '<td>'
                html += response['sat_seriefel']
                html += '</td>'
                html += '</tr>'

                html += '<tr>'
                html += '<th>'
                html += 'Correlativo'
                html += '<th>'
                html += '<td>'
                html += response['sat_correlativofel']
                html += '</td>'
                html += '</tr>'
                $("#fels_aut tbody tr").remove();
            	$('#fels_aut tbody').append(html);
            	$('#ShowAutorizacionModal').modal('show');
	        },
	        error: function(error){
	            console.log(error);
	        }
	    });
      }
      function fn_mostrarerror(id){
      	$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        url: "{{ route('trae_detalle_errores') }}",
	        method: "POST",
	        data: {id: id
	              },
	        success: function(response){
                var html = '';
                for (var i = 0; i < response.length; i++) {
                	html += '<tr>'
                	html += '<td>'
                	html += response[i]['mensaje']
                	html += '</td>'	
                	html += '</tr>'	
                }
                $("#fels_err tbody tr").remove();
            	$('#fels_err tbody').append(html);
            	$('#ShowErrorModal').modal('show');
	        },
	        error: function(error){
	            console.log(error);
	        }
	    });	
      }
    </script>
@endsection
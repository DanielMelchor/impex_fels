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
							@if($l->flag == 'P' || $l->flag == 'E')
								<td><a href="#" onclick="fn_modalcorreo( {{$l->id}} ); return false;">{{ $l->correo_electronico }}</a></td>
							@else
								<td>{{ $l->correo_electronico }}</td>
							@endif
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
	<!-- Modal correo -->
	<div class="modal fade" id="ModalCorreo" tabindex="-1" role="dialog" aria-labelledby="ModalCorreoLabel" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-centered" role="document">
			<div class="modal-content">
				<form class="form-horizontal" id="myForm" name="contact" action="#">
				<div class="card card-navy">
					<div class="card-header">
						<div class="row">
							<div class="col-md-8">
								<h6>Cambio de correo electrónico</h6>
							</div>
							<div class="col-md-4" style="text-align: right;">
								<button type="submit" class="btn btn-sm btn-success" title="Grabar"><i class="fas fa-save"></i></button>
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" title="Cerrar"><i class="fas fa-sign-out-alt"></i></button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<input type="hidden" id="ccid" name="ccid">
						<div class="row">
	        				<div class="col-md-10 offset-md-1 mb-3">
	        					<div class="input-group">
							  		<div class="input-group-prepend">
								    	<label class="input-group-text" id="">Empresa</label>
								  	</div>
								  	<input type="text" id="ccempresa" name="ccempresa" class="form-control text-center" disabled>
								</div>
	        				</div>
	        			</div>
	        			<div class="row">
	        				<div class="col-md-10 offset-md-1 mb-3">
	        					<div class="input-group">
							  		<div class="input-group-prepend">
								    	<label class="input-group-text" id="">Tipo Documento</label>
								  	</div>
								  	<input type="text" id="cctipodocumento" name="cctipodocumento" class="form-control text-center" disabled>
								</div>
	        				</div>
	        			</div>
	        			<div class="row">
	        				<div class="col-md-4 offset-md-1 mb-3">
	        					<div class="input-group">
							  		<div class="input-group-prepend">
								    	<label class="input-group-text" id="">Serie</label>
								  	</div>
								  	<input type="text" id="ccserie" name="ccserie" class="form-control text-center" disabled>
								</div>
	        				</div>
	        				<div class="col-md-6 mb-3">
	        					<div class="input-group">
							  		<div class="input-group-prepend">
								    	<label class="input-group-text" id="">Documento</label>
								  	</div>
								  	<input type="text" id="ccdocumento" name="ccdocumento" class="form-control" style="text-align: right;" disabled>
								</div>
	        				</div>
	        			</div>
	        			<div class="row">
	        				<div class="col-md-10 offset-md-1 mb-3">
	        					<div class="input-group">
							  		<div class="input-group-prepend">
								    	<label class="input-group-text" id="">Fecha</label>
								  	</div>
								  	<input type="text" id="ccfecha" name="ccfecha" class="form-control text-center" disabled>
								</div>
	        				</div>
	        			</div>
	        			<div class="row">
	        				<div class="col-md-10 offset-md-1 mb-3">
	        					<div class="input-group">
							  		<div class="input-group-prepend">
								    	<label class="input-group-text" id="">Nombre</label>
								  	</div>
								  	<input type="text" id="ccnombre" name="ccnombre" class="form-control text-center" disabled>
								</div>
	        				</div>
	        			</div>
	        			<div class="row">
	        				<div class="col-md-10 offset-md-1 mb-3">
	        					<div class="input-group">
							  		<div class="input-group-prepend">
								    	<label class="input-group-text" id="">Correo Electrónico</label>
								  	</div>
								  	<input type="mail" id="cccorreo" name="cccorreo" class="form-control" autofocus required>
								</div>
	        				</div>
	        			</div>
	        			<div class="row">
	        				<div class="col-md-10 offset-md-1 mb-3">
	        					<div class="input-group">
							  		<div class="input-group-prepend">
								    	<label class="input-group-text" id="">Total</label>
								  	</div>
								  	<input type="number" id="cctotal" name="cctotal" class="form-control" style="text-align: right;" disabled>
								</div>
	        				</div>
	        			</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /Modal correo -->
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

  	function fn_modalcorreo($id){
      	$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        url: "{{ route('trae_encabezado_documento') }}",
	        method: "POST",
	        data: {id: $id
	              },
	        success: function(response){
	        	document.getElementById('ccid').value = response.id;
	        	document.getElementById('ccempresa').value = response.nombre_comercial;
	        	document.getElementById('cctipodocumento').value = response.tipodocumento_descripcion;
	        	document.getElementById('ccserie').value = response.serie;
	        	document.getElementById('ccdocumento').value = response.numdoc;
	        	document.getElementById('ccfecha').value = convertDateFormat(response.fecha_emision);
	        	document.getElementById('ccnombre').value = response.nombre_factura;
	        	document.getElementById('cccorreo').value = response.correo_electronico;
	        	document.getElementById('cctotal').value = response.total_documento;
	        	$("#ModalCorreo").modal();
	        },
	        error: function(error){
	            console.log(error);
	        }
        });	
	}
	function convertDateFormat(string) {
        var date = string.replace('00:00:00','');
        var info = date.split('-').reverse().join('/');
        return info;
   	}

   	function actualizar_correo(){
   		var correo = document.getElementById('cccorreo').value;
   		var id = document.getElementById('ccid').value;
   		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        url: "{{ route('actualizar_correo') }}",
	        method: "POST",
	        data: {id: id,
	        	   email: correo
	              },
	        success: function(response){
	        	swal({
                    title: 'Trabajo Finalizado !!!',
                    text: response,
                    type: 'success',
                    },
                    function(){
                        return window.location.href = "{{route('consulta_fel')}}";
                    }
                );

	        },
	        error: function(error){
	            console.log(error);
	        }
        });	
   	}

	   	$(function(){
	        $("#myForm").submit(function(){
	            actualizar_correo();
	            return false;
	        })
	    });
    </script>
@endsection
@extends('admin.layout')
@section('titulo')
	Cambio de contraseña
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
	<div class="content-fluid">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<form role="form" method="POST" action="{{ route('actualizar_contrasena') }}">
					@csrf
					{{ csrf_field() }}
					<div class="card card-navy">
						<div class="card-header">
							<div class="row">
								<div class="col-md-8">
									<h6>Usurio {{ Auth::user()->name }}</h6>
								</div>
								<div class="col-md-4" style="text-align: right;">
									<button type="submit" class="btn btn-success btn-sm" title="Guardar"><i class="fas fa-save"></i></button>
        							<a href="{{ route('usuarios') }}" class="btn btn-danger btn-sm" title="Rregresar a lista de Usuarios"><i class="fas fa-sign-out-alt"></i></a>
								</div>
							</div>
	        			</div>
	        			<div class="card-body">
							<div class="row text-center">
			        			<div class="col-md-6 offset-md-3">
			        				<label for="actual">Contraseña Actual</label>
			        			</div>
			        		</div>
	        				<div class="row text-center">
			        			<div class="input-group col-md-6 offset-md-3">
			        				<input type="password" class="form-control" aria-describedby="addon-wrapping" id="actual" name="actual" value="{{ old('actual') }}" autofocus required>
			        			</div>
			        		</div>

							<div class="row text-center">
			        			<div class="col-md-6 offset-md-3">
			        				<label for="contrasena">Nueva Contraseña</label>
			        			</div>
			        		</div>
	        				<div class="row text-center">
			        			<div class="input-group col-md-6 offset-md-3">
			        				<input type="password" class="form-control" aria-describedby="addon-wrapping" id="contrasena" name="contrasena" value="{{ old('contrasena') }}" required>
			        			</div>
			        		</div>
			        		<div class="row text-center">
			        			<div class="col-md-6 offset-md-3">
			        				<label for="confirmar">Confirmar Contraseña</label>
			        			</div>
			        		</div>
			        		<div class="row text-center">
			        			<div class="input-group col-md-6 offset-md-3">
			        				<input type="password" class="form-control" aria-describedby="addon-wrapping" id="confirmar" name="confirmar" value="{{ old('confirmar') }}" required>
			        			</div>
			        		</div>
	        			</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
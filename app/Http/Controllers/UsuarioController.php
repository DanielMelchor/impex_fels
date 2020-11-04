<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\model_has_roles;
use DB;
use Redirect;
use App\user;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$usuarios = user::all();
    	/*$user = Auth::user();
    	$user->hasAnyRole('Administrador');
    	dd($user);*/
    	return view('usuarios.index', compact('usuarios'));
    }

    public function index_contrasena(){
    	return view('usuarios.edit_contrasena');
    }

    public function store(Request $request){
		$validData = $request->validate([
	        'username'    => 'required|min:3',
	        'name'        => 'required'
	    ]);

	    $usuario = new user();
	    $usuario->username = $validData['username'];
	    $usuario->name     = $validData['name'];
	    $usuario->password = Hash::make('impex');
	    $usuario->email    = $validData['username'];
	    $usuario->save();

	    return redirect(route('usuarios'))->with('success', 'Usuario grabado con exito!');
    }

    public function edit($id){
    	$usuario         = user::findOrFail($id);
    	$roles           = Role::all();
    	$roles_asignados = model_has_roles::where('model_id', $id)->select('role_id')->get()->toArray();
    	return view('usuarios.edit', compact('usuario', 'roles', 'roles_asignados'));
    }

    public function update(Request $request, $id){
		$validData = $request->validate([
	        'username' => 'required',
	        'name' => 'required'
	    ]);


	    $usuario = user::findOrFail($id);
	    $usuario->username = $validData['username'];
	    $usuario->name     = $validData['name'];
	    $usuario->save();

	    $roles = $request->callbacks;

	    DB::table('model_has_roles')->where('model_id', $id)->delete();

		if (isset($roles)) {
			foreach ($roles as $key => $role) {
				$usuario->assignRole($role);
		    	/*$r = new model_has_roles();
		    	$r->role_id  = $role;
		    	$r->model_type = 'App\User';
		    	$r->model_id = $id;
		    	$r->save();*/
		    }
		}

	    return redirect(route('usuarios'))->with('success', 'Usuario grabado con exito!');
    }

    public function update_contrasena(Request $request){

    	if (Hash::check($request->actual, Auth::user()->password)){
			if (isset($roles)) {
		    			# code...
		    		}    		if ($request->contrasena == $request->confirmar) {
	    		$usuario = user::findOrFail(Auth::user()->id);
	    		$usuario->password = Hash::make($request->contrasena);
	    		$usuario->save();

	    		//return redirect(route('home'))->with('success', 'Usuario modificado con exito!');
	    		return Redirect::back()->with(['success', 'Contraseña Actualizada con extio !!!']);
	    	}else{
	    		//return redirect(route('home'))->with('success', 'Error datos no concuerdan!');
	    		return Redirect::back()->with(['success', 'Contraseña Actualizada con extio !!!']);
	    	}	
    	}else{
    		dd('contraseña actual no concuerda con la ingresada');
    	}
    }

    public function update_pass($usuario_id){
    	$usuario = user::findOrFail($usuario_id);
		$usuario->password = Hash::make('impex');
		$usuario->save();
		return redirect(route('usuarios'))->with('success', 'Contraseña restablecida con exito!');
    }
}

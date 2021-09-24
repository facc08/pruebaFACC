<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role();
        $role->name =  $request->input('name');
        $respuesta = $role->save();

        if ($respuesta) {
            return response()->json(['message' => 'Rol creado exitosamente'], 201);
        }
        return response()->json(['message' => 'Error en la transacción'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role = Role::find($request->input('id'));

        if (!empty($request->input('name'))) {
            $role->name = $request->input('name');
        }

        $update = $role->save();

        if ($update) {
            return response()->json(['message' => 'Rol actualizado exitosamente.']);
        }

        return response()->json(['message' => 'Error en la transacción'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $role = Role::find($request->input('id'));
        $delete = $role->delete();

        if ($delete) {
            return response()->json(['message' => 'Rol eliminado exitosamente']);
        }

        return response()->json(['message' => 'Error en la transacción'], 500);
    }

    public function AsignarRolUsuario(Request $request)
    {

        $roleUser = new RoleUser();
        $roleUser->user_id =  $request->input('user_id');
        $roleUser->role_id =  $request->input('role_id');
        $respuesta = $roleUser->save();

        if ($respuesta) {
            return response()->json(['message' => 'Asignado exitosamente'], 201);
        }
        return response()->json(['message' => 'Error en la transacción'], 500);

    }

    public function ListaUsuarioRol()
    {

        $roleUser = DB::table('role_user')
            ->join('users', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.name as usuario', 'roles.name as rol', 'role_user.user_id', 'role_user.role_id')
            ->get();

        return $roleUser;

    }
}

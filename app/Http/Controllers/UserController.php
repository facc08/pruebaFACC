<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
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
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$request->validated();

        $usuario = new User();
        $usuario->name =  $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->email_verified_at = now();
        $usuario->remember_token = Str::random(10);
        $usuario->password = ($request->input('password') != "") ? bcrypt($request->input('password')) : '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

        $respuesta = $usuario->save();

        if ($respuesta) {
            return response()->json(['message' => 'Usuario creado exitosamente'], 201);
        }
        return response()->json(['message' => 'Error en la transacción'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $user = User::find($request->input('id'));

        if (!empty($request->input('name'))) {
            $user->name = $request->input('name');
        }

        if (!empty($request->input('email'))) {
            $user->email = $request->input('email');
        }

        if (!empty($request->input('password'))) {
            $user->password = ($request->input('password') != "") ? bcrypt($request->input('password')) : '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        }

        $update = $user->save();

        if ($update) {
            return response()->json(['message' => 'Usuario actualizado exitosamente.']);
        }

        return response()->json(['message' => 'Error en la transacción'], 500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->input('id'));
        $delete = $user->delete();

        if ($delete) {
            return response()->json(['message' => 'Usuario eliminado exitosamente']);
        }

        return response()->json(['message' => 'Error en la transacción'], 500);
    }

}

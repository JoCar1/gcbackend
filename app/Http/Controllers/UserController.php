<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //usar rando 10 
        $limit = $request->get('limit');
        //Order
        $columna = $request->get('columna');
        $order = $request->get('order');
        $filter = $request->get('filter');
        $ff = $request->get('ff', $filter==''?'%%':'%'.$filter.'%');
        $data = User::where($columna, 'like', $ff)
                ->orderBy($columna,$order)->paginate($limit);
        return response()->json(['data'=>$data], 200); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'rol' => 'required'
        ]);
        $data = $request->all();
        User::create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'email_verified_at' => (string) date('Y-m-d H:i:s'),
            'telefono' => $data['telefono'],
            'celular' => $data['celular'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'rol' => $data['rol']
        ]);  
        $mensaje = "Registrado correctamente";

        return response()->json(['mensaje'=>$mensaje], 200);
        // return response('Hello World', 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => ['required',Rule::unique('users')->ignore($id)],
            'username' => ['required',Rule::unique('users')->ignore($id)],
            'password' => 'required|string|min:6',
            'rol' => 'required',
            'organizativa_unidad_id' => 'required'
        ]);
        $data = $request->all();
        $user->nombre = $data['nombre'];
        $user->email = $data['email'];
        $user->telefono = $data['telefono'];
        $user->celular = $data['celular'];
        $user->username = $data['username'];
        if($user->password){
           $user->password = Hash::make($data['password']); 
        } 
        $user->rol = $data['rol'];
        $user->organizativa_unidad_id = $data['organizativa_unidad_id'];
        $user->update();
        $mensaje = "Actualizado correctamente";

        return response()->json(['mensaje'=>$mensaje], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $mensaje = "Eliminado correctamente";
        return response()->json(['mensaje'=>$mensaje], 200);
    }
}

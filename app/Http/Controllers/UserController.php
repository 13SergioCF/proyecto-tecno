<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('usuario.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all(); // Obtener todos los roles para el formulario
        return view('usuario.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required', // Validar que se envíe un rol
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'genero' => $request->genero,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Encriptar contraseña
        ]);

        // Asignar rol al usuario
        $user->assignRole($request->role);

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Obtener roles para el formulario
        return view('usuario.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required', // Validar que se envíe un rol
        ]);

        // Buscar el usuario
        $user = User::findOrFail($id);

        // Actualizar datos del usuario
        $user->update([
            'name' => $request->name,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'genero' => $request->genero,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'email' => $request->email,
            // Si se envía una nueva contraseña
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Actualizar rol
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('usuario.index');
    }
}

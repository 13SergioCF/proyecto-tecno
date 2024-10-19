<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use PDF;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

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
        $validatedData = $request->validate([
            'name' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'genero' => 'required',
            'fecha_nacimiento' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'rol' => 'required',
        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'apellido_paterno' => $validatedData['apellido_paterno'],
            'apellido_materno' => $validatedData['apellido_materno'],
            'genero' => $validatedData['genero'],
            'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        $user->assignRole($request->input('rol'));
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
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
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente');
    }

    public function exportPdf()
    {
        $users = User::all(); // Obtener los usuarios

        // Cambia la vista a la ruta correcta
        $pdf = PDF::loadView('usuario.pdf', compact('users'));
        return $pdf->download('usuarios.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new UsersExport, 'usuarios.xlsx');
    }
}

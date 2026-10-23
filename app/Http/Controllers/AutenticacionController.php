<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AutenticacionController extends Controller
{
    /**
     * Muestra el formulario para crear una cuenta nueva.
     */
    public function mostrarRegistro()
    {
        return view('autenticacion.registro');
    }

    /**
     * Valida los datos del formulario y guarda el usuario nuevo.
     */
    public function registrar(Request $request)
    {
        $datos = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'email.required'     => 'El correo es obligatorio.',
            'email.email'        => 'Escribe un correo válido.',
            'email.unique'       => 'Ese correo ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        User::create($datos);

        return redirect()->route('registro')->with('exito', 'Cuenta creada correctamente.');
    }
}
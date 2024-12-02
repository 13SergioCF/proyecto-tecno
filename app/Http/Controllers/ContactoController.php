<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function index()
    {
        return view('contacto.index');
    }

    public function store(Request $request)
    {
        // Validación de los campos
        $request->validate([
            'asunto' => 'required',
            'nombre' => 'required',
            'correo_remitente' => 'required|email',
            'correo_destino' => 'required|email',
            'mensaje' => 'required',
            'adjunto' => 'nullable|file|mimes:pdf', // 'nullable' permite que el adjunto no sea obligatorio
        ]);

        // Obtener datos necesarios
        $data = $request->only(['asunto', 'nombre', 'correo_remitente', 'correo_destino', 'mensaje']);
        $adjunto = $request->hasFile('adjunto') ? $request->file('adjunto') : null;

        try {
            // Crear el Mailable y enviar el correo
            $correo = new ContactoMailable($data, $adjunto);
            Mail::to($data['correo_destino'])->send($correo);

            // Redirigir con mensaje de éxito
            return redirect()->route('contacto.index')->with('info', 'Tu mensaje se ha enviado correctamente.');
        } catch (\Exception $e) {
            // Loggear el error y redirigir con mensaje de error
            \Log::error('Error al enviar el correo:', ['error' => $e->getMessage()]);
            return redirect()->route('contacto.index')->with('error', 'Ocurrió un error al enviar el mensaje.');
        }
    }
}

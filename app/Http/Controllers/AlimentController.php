<?php

namespace App\Http\Controllers;

use App\Models\Aliment;
use App\Models\FoodType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use PDF;

class AlimentController extends Controller
{
    // Mostrar la lista de alimentos
    public function index(Request $request)
    {
        $estado = $request->input('estado', 'all'); // Recibir filtro de estado
        $foodType = $request->input('food_type', null);

        $aliments = Aliment::query();

        if ($estado !== 'all') {
            $aliments->where('estado', $estado);
        }

        if ($foodType) {
            $aliments->where('food_type_id', $foodType);
        }

        $aliments = $aliments->with('foodType')->get();

        $foodTypes = FoodType::where('estado', 'activo')->get();

        return view('aliments.index', compact('aliments', 'foodTypes', 'estado', 'foodType'));
    }




    // Crear un nuevo alimento
    public function create()
    {
        // Obtener todos los tipos de alimento
        $foodTypes = FoodType::pluck('nombre', 'id'); // Cambia esto si usas otro modelo o método

        return view('aliments.create', compact('foodTypes'));
    }

    public function show($id)
    {
        try {
            // Buscar el alimento por su ID
            $aliment = Aliment::findOrFail($id);

            // Retornar la vista con el alimento encontrado
            return view('aliments.show', compact('aliment'));
        } catch (\Exception $e) {
            // Si no se encuentra el alimento
            return redirect()->route('aliments.index')->with('error', 'Alimento no encontrado.');
        }
    }


    // Almacenar un nuevo alimento
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'food_type_id' => 'required|exists:food_types,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',  // Validación de imagen
            'video' => 'nullable|mimes:mp4,avi,mov|max:50000',  // Validación de video
        ]);

        try {
            $aliment = new Aliment();
            $aliment->nombre = $request->nombre;
            $aliment->descripcion = $request->descripcion;
            $aliment->food_type_id = $request->food_type_id;
            $aliment->estado = 'activo'; // Establecer el estado por defecto

            // Manejo de la imagen
            if ($request->hasFile('imagen')) {
                $imagenPath = $request->file('imagen')->store('public/imagenes');
                $aliment->imagen_url = Storage::url($imagenPath);
            }

            // Manejo del video
            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('public/videos');
                $aliment->video_url = Storage::url($videoPath);
            }

            $aliment->save();

            return redirect()->route('aliments.index')->with('success', 'Alimento agregado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al agregar el alimento: ' . $e->getMessage());
        }
    }




    // Editar alimento
    public function edit($id)
    {
        try {
            // Buscar el alimento por ID o lanzar una excepción si no existe
            $aliment = Aliment::findOrFail($id);

            // Obtener los tipos de alimentos
            $foodTypes = FoodType::pluck('nombre', 'id');

            return view('aliments.edit', compact('aliment', 'foodTypes'));
        } catch (\Exception $e) {
            // Redirigir con un mensaje de error si no se encuentra el alimento
            return redirect()->route('aliments.index')->with('error', 'El alimento no fue encontrado.');
        }
    }

    public function update(Request $request, $id)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo',
            'food_type_id' => 'required|exists:food_types,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'video' => 'nullable|mimes:mp4,avi,mov|max:50000',
        ]);

        try {
            // Buscar el alimento por ID
            $aliment = Aliment::findOrFail($id);

            // Actualizar los campos
            $aliment->nombre = $validated['nombre'];
            $aliment->descripcion = $validated['descripcion'];
            $aliment->estado = $validated['estado'];
            $aliment->food_type_id = $validated['food_type_id'];

            // Manejo de la imagen
            if ($request->hasFile('imagen')) {
                if ($aliment->imagen_url) {
                    Storage::delete('public/imagenes/' . basename($aliment->imagen_url));
                }
                $imagenPath = $request->file('imagen')->store('public/imagenes');
                $aliment->imagen_url = Storage::url($imagenPath);
            }

            // Manejo del video
            if ($request->hasFile('video')) {
                if ($aliment->video_url) {
                    Storage::delete('public/videos/' . basename($aliment->video_url));
                }
                $videoPath = $request->file('video')->store('public/videos');
                $aliment->video_url = Storage::url($videoPath);
            }

            // Guardar los cambios
            $aliment->save();

            // Responder con JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Alimento actualizado correctamente.',
            ]);
        } catch (\Exception $e) {
            // Capturar errores
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar el alimento: ' . $e->getMessage(),
            ], 500);
        }
    }















    public function destroy($id)
    {
        $aliment = Aliment::find($id);

        if (!$aliment) {
            return response()->json(['message' => 'Alimento no encontrado.'], 404);
        }

        try {
            // Cambiar el estado a "inactivo" en lugar de eliminarlo
            $aliment->update(['estado' => 'inactivo']);
            return response()->json(['message' => 'El estado del alimento se actualizó a inactivo.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el estado: ' . $e->getMessage()], 500);
        }
    }







    // Exportar a PDF
    public function exportPdf(Request $request)
    {
        $estado = $request->input('estado', null);
        $foodType = $request->input('food_type', null);

        $aliments = Aliment::query();

        if ($estado) {
            $aliments = $aliments->where('estado', $estado);
        }

        if ($foodType) {
            $aliments = $aliments->where('food_type_id', $foodType);
        }

        // Cargar relaciones
        $aliments = $aliments->with('foodType')->get();

        $pdf = PDF::loadView('aliments.pdf', compact('aliments'));
        return $pdf->download('alimentos.pdf');
    }

    public function uploadMedia(Request $request, $id)
    {
        $request->validate([
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',  // 10MB max para imagen
            'video' => 'nullable|mimes:mp4,avi,mov|max:50000',  // 50MB max para video
        ]);

        // Encuentra el alimento por su ID
        $alimento = Aliment::findOrFail($id);

        // Si se sube una imagen
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('public/imagenes');  // Guarda la imagen en "storage/app/public/imagenes"
            $alimento->imagen_url = Storage::url($imagenPath);  // Almacena la URL en la base de datos
        }

        // Si se sube un video
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('public/videos');  // Guarda el video en "storage/app/public/videos"
            $alimento->video_url = Storage::url($videoPath);  // Almacena la URL en la base de datos
        }

        // Guarda los cambios
        $alimento->save();

        return response()->json(['message' => 'Archivos cargados exitosamente']);
    }
}

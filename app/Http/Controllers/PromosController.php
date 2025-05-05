<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Promo; // Cambiamos el modelo a Promo

class PromosController extends Controller

{

    public function crear(Request $request)
    {
        $request->validate([
            'nueva_imagen' => 'required|image|mimes:jpg,jpeg|max:2048',
        ]);
    
        try {
            // Obtener el archivo de manera segura
            $imagen = $request->file('nueva_imagen');
            
            // Convertir la imagen a datos binarios
            $imagenBinaria = file_get_contents($imagen->getRealPath());
            $nombreWeb = Auth::user()->nombre;
            Promo::create([
                'nombre' => $nombreWeb,  // ID del usuario
                'imagenes' => $imagenBinaria,
                // Si tu tabla tiene timestamps, Laravel los agregará automáticamente
            ]);
    
            return redirect()->back()->with('success', 'Promoción agregada correctamente');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al subir: ' . $e->getMessage());
        }
    }

    public function editPromoForm()
    {
        $nombreWeb = Auth::user()->nombre;

        // Consultamos directamente la tabla promos
        $promos = Promo::where('nombre', $nombreWeb)->get();

        return view('promos.editar', compact('promos'));
    }

    public function updatePromo(Request $request, $id)
    {
        $request->validate([
            'nueva_imagen' => 'required|image|mimes:jpg,jpeg|max:2048',
        ]);

        try {
            $promo = Promo::findOrFail($id);
            
        
            // Leer y guardar la imagen en el campo correcto
            $imageBinary = file_get_contents($request->file('nueva_imagen')->getRealPath());
            $promo->imagenes = $imageBinary; 
            $promo->save();

            return redirect()->back()->with('success', 'Promo actualizada exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }



    public function eliminar($id)
    {
        try {
            $promo = Promo::findOrFail($id);
    
            // Eliminar el archivo de video si existe
            if ($promo->video && Storage::disk('public')->exists($promo->video)) {
                Storage::disk('public')->delete($promo->video);
            }
    
            // Eliminar el registro de la base de datos
            $promo->delete();
    
            return redirect()->back()->with('success', 'Promoción eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la promoción.');
        }
    }
    


public function guardarLabel(Request $request)
{
   
    $request->validate([
        'label' => 'required|string|max:60',
        'emoji' => 'required|string',
        'nombre' => 'required|integer', // o string si es texto
        'video' => 'nullable|mimetypes:video/mp4|max:4096', // 4MB en kilobytes
    ]);
    $videoPath = null;
    if ($request->hasFile('video')) {
        $videoFile = $request->file('video');
        $hashName = md5_file($videoFile->getRealPath()) . '.' . $videoFile->getClientOriginalExtension();
    
        // Solo guardar si no existe ya ese archivo
        if (!Storage::disk('public')->exists('videos/' . $hashName)) {
            $videoFile->storeAs('videos', $hashName, 'public');
        }
    
        $videoPath = 'videos/' . $hashName;
    }

    $nombreWeb = Auth::user()->nombre;
    $textoFinal = $request->emoji . ' ' . $request->label;

    Promo::create([
        'label' => $textoFinal,
        'nombre' => $nombreWeb,
        'video' => $videoPath,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    //dd($request->all());
    return redirect()->back()->with('success', 'Promoción guardada correctamente.');

    
}


public function actualizarTexto(Request $request, $id)
{
    $request->validate([
        'label' => 'required|string|max:60',
        'emoji' => 'required|string',
        'video' => 'nullable|mimes:mp4|max:4096', // 4MB
    ]);

    $promo = Promo::findOrFail($id);

    $textoFinal = $request->emoji . ' ' . $request->label;

    $data = [
        'label' => $textoFinal,
    ];

    // Si se subió un nuevo video
    if ($request->hasFile('video')) {
        // Eliminar video anterior si existe
        if ($promo->video && Storage::disk('public')->exists($promo->video)) {
            Storage::disk('public')->delete($promo->video);
        }

        // Guardar nuevo video
        $videoPath = $request->file('video')->store('videos', 'public');
        $data['video'] = $videoPath;
    }

    // Actualizar los datos
    $promo->update($data);

    return redirect()->back()->with('success', 'Texto actualizado correctamente');
}



}
<?php

namespace App\Http\Controllers;

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
    
            Promo::create([
                'nombre' => auth()->id(),  // ID del usuario
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
        $userId = Auth::id();

        // Consultamos directamente la tabla promos
        $promos = Promo::where('nombre', $userId)->get();

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
}
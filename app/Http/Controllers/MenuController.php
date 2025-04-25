<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function editImageForm()
    {
        $menus = Menu::all();
        return view('menu.editar', compact('menus'));
    }

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'nueva_imagen' => 'required|image|mimes:jpg,jpeg|max:2048',
        ]);

        try {
            $menu = Menu::findOrFail($id);

            // Leer imagen como contenido binario
            $imageBinary = file_get_contents($request->file('nueva_imagen')->getRealPath());

            // Guardar directamente en la base de datos
            $menu->imagenes = $imageBinary;
            $menu->save();

            return redirect()->back()->with('success', 'Imagen actualizada exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }
}

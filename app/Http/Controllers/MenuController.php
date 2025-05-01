<?php 

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{ 
    public function editImageForm()
    {
        $nombreWeb = Auth::user()->nombre;
    
        $menus = Menu::where('nombre', $nombreWeb)
                     ->whereNotNull('imagenes')
                     ->get();
    
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

    public function index()
    {
        $usuarioNombre = Auth::user()->nombre;
        $canvaLink = Menu::where('nombre', $usuarioNombre)->value('canva');
    
        return view('dashboard', compact('canvaLink'));
    }


    public function vistaTv($pageName)
    {
        $imagenes = Menu::where('nombre', $pageName)->pluck('imagenes');
        $promo = Menu::where('nombre', $pageName)->first();
        $tipoNormal = false;
    
        return view('tv', compact('imagenes', 'promo', 'pageName', 'tipoNormal'));
    }


}

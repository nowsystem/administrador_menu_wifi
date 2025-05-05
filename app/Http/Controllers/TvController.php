<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Models\Menu;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;


class TvController extends Controller
{
    

    public function imagenesChecksum($pageName)
    {
        // Checksum basado en el contenido binario
        $imagenes = Menu::where('nombre', $pageName)
            ->get()
            ->pluck('imagenes')
            ->toArray();

      $video = DB::table('promos')->where('nombre', $pageName)->value('video');

return response()->json([
    'checksum' => md5(implode('', $imagenes) . ($video ?? ''))
]);
    }

    public function getPromo($pageName)
    {
        $promo = DB::table('promos')
            ->where('nombre', $pageName)
            ->select('label')
            ->first();

        return response($promo->label ?? '');
    }


    public function cargarVista(Request $request)
    {
        $vista = $request->input('vista');

        // Seguridad básica
        if (!preg_match('/^tv\d+$/', $vista)) {
            return response()->json(['error' => 'Nombre de vista inválido.'], 400);
        }

        // Verifica si la vista existe en la carpeta /views/screen
        if (view()->exists("screen.$vista")) {
            return view("screen.$vista")->render();
        }

        return response()->json(['error' => 'Vista no encontrada.'], 404);
    }


    public function seleccionarVista()
{
    $user = Auth::user();

    // Solo permitir acceso a usuarios tipo "tv"
    if ($user->tipo !== 'tv') {
        abort(403, 'Acceso no autorizado');
    }

    return view('screen.elegir_diseno'); // vista con los 4 diseños
}

public function guardarVista(Request $request)
{
    $request->validate([
        'vista' => 'required|in:1,2,3,4'
    ]);

    $user = Auth::user();

    $user->page = $request->vista;
    $user->page = (int) $request->vista;
    $user->save();
    return redirect()->route('tv.seleccionar')->with('success', 'Diseño de pantalla guardado correctamente.');
}

public function verPantalla($pageName)
{
    // Buscar el usuario por el campo nombre
    $user = \App\Models\User::where('nombre', $pageName)->firstOrFail();

    // Obtener el número del campo 'page' (1 a 4)
    $page = $user->page;

    // Validar que sea un número del 1 al 4
    if (!in_array($page, [1, 2, 3, 4])) {
        abort(404, 'Vista no asignada correctamente');
    }

    // Convertir el número a nombre de vista: 1 => 'tv1', etc.
    $vistaAsignada = 'tv' . $page;

    // Cargar imágenes igual que en show()
    $imagenes = \App\Models\Menu::where('nombre', $pageName)
        ->get()
        ->pluck('imagenes')
        ->map(function ($blob) {
            return base64_encode($blob);
        });

        return view("screen.$vistaAsignada", compact('pageName', 'imagenes'));
}


public function pageChecksum($pageName)
{
    // Trae el número de página (tv1, tv2, etc.) asociado al nombre
    $currentPage = DB::table('users')
        ->where('nombre', $pageName)
        ->value('page');

    return response()->json([
        'checksum' => md5($currentPage)
    ]);
}


}



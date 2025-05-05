<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Promo;
use App\Models\Cliente;
use App\Models\User;   // ðŸ‘ˆ Importamos User
use App\Models\Metrica; // ðŸ‘ˆ Importamos Metrica (la crearemos tambiÃ©n)


class MenuPageController extends Controller
{
  

    public function show($pageName)
    {

        $cliente = Cliente::where('nombre', $pageName)->first();

    // Si no se encuentra, devolver un error 404
    if (!$cliente) {
        return abort(404, 'Pagina no encontrada');
    }

        

        // Buscar imÃ¡genes de menus
        $imagenes = Menu::where('nombre', $pageName)->pluck('imagenes');
          // Buscar promo
        $promo = Promo::where('nombre', $pageName)->first();
      // Buscar el tipo en users
      $user = User::where('nombre', $pageName)->first();

        // Definir la variable tipoNormal (boolean)
        $tipoNormal = true; // valor por defecto
        if ($user && $user->tipo == 'especial') {
            $tipoNormal = false;
        }

         return view('menu_page', compact('imagenes', 'promo', 'pageName','tipoNormal'));
    }

    
    // MÃ©todo para recibir el formulario de contacto
    public function guardarMetrica(Request $request, $pageName)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'comentarios' => 'required|string|max:500',
            
       
        ]);
        $validated['referencia'] = $pageName;
        // Guardar en la tabla metrica
        Metrica::create($validated);

        // Responder sin salir de la pÃ¡gina
        return back()->with('success', 'Datos enviados correctamente.');
    }


    
}


<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class ClientesController extends Controller
{
    public function mostrarClientes()
    {
        // Buscar todas las imágenes del menú donde el nombre sea "Kabuky"
        $menus = Menu::where('nombre', '1')
            ->whereNotNull('imagenes')
            ->get();

        if ($menus->isEmpty()) {
            abort(404, 'No se encontraron imágenes con el nombre Kabuky.');
        }

        return view('clientes-publico', ['imagenes' => $menus]);
    }
}

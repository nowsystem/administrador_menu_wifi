<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\Promo;
use App\Models\Cliente;

class ControlController extends Controller
{
    public function inicio()
    {
        return view('control.inicio');
    }

    public function editar()
    {
        $users = User::all();
        $menus = Menu::all();
        $promos = Promo::all();
        $clientes = Cliente::all();
        return view('control.editar', compact('users', 'menus', 'promos', 'clientes'));
    }

    // --- USERS CRUD ---
    public function crearUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tipo' => $request->tipo ?? 'usuario',
        ]);

        return back()->with('success', 'Usuario creado correctamente');
    }

    public function actualizarUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->only(['name', 'nombre','email', 'tipo']));

        return back()->with('success', 'Usuario actualizado correctamente');
    }

    public function eliminarUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'Usuario eliminado correctamente');
    }

    // --- MENUS CRUD ---
    public function crearMenu(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagenes' => 'nullable|image',
            'canva' => 'required|string|max:255',
        ]);

        $menu = new Menu();
        $menu->nombre = $request->nombre;
        $menu->canva = $request->canva; 

        if ($request->hasFile('imagenes')) {
            $menu->imagenes = file_get_contents($request->file('imagenes')->path());
        }

        $menu->save();

        return back()->with('success', 'Menu creado correctamente');
    }

    public function actualizarMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->nombre = $request->nombre;
        $menu->canva = $request->canva;

        if ($request->hasFile('imagenes')) {
            $menu->imagenes = file_get_contents($request->file('imagenes')->path());
        }

        $menu->save();

        return back()->with('success', 'Menu actualizado correctamente');
    }

    public function eliminarMenu($id)
    {
        Menu::destroy($id);
        return back()->with('success', 'Menu eliminado correctamente');
    }

    // --- PROMOS CRUD ---
    public function crearPromo(Request $request)
{
    $request->validate([
        'imagenes' => 'required|image|mimes:jpg,jpeg|max:2048',
        'nombre' => 'required|string|max:255',
    ]);

    try {
        if ($request->hasFile('imagenes')) {
            // Obtener el archivo de manera segura
            $imagen = $request->file('imagenes');
            // Convertir la imagen a datos binarios
            $imagenBinaria = file_get_contents($imagen->getRealPath());

            // Crear la promoción
            Promo::create([
                'nombre' => $request->nombre,
                'imagenes' => $imagenBinaria,
            ]);

            return redirect()->back()->with('success', 'Promoción agregada correctamente');
        } else {
            return redirect()->back()->with('error', 'No se recibió la imagen correctamente.');
        }

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al subir: ' . $e->getMessage());
    }
}


    public function actualizarPromo(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

          
    $request->validate([
        'nombre' => 'required|string|max:255',
        'imagenes' => 'nullable|image|mimes:jpg,jpeg|max:2048', // 'nullable' porque es opcional
    ]);

    $promo->nombre = $request->nombre; // Actualiza el nombre
    
        if ($request->hasFile('imagenes')) {
            $promo->imagenes = base64_encode(file_get_contents($request->file('imagenes')->path()));
        }

        $promo->save();

        return back()->with('success', 'Promoción actualizada correctamente');
    }

    public function eliminarPromo($id)
    {
        Promo::destroy($id);
        return back()->with('success', 'Promoción eliminada correctamente');
    }

    // --- CLIENTES CRUD ---
    public function crearCliente(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            
        ]);

        Cliente::create($request->only(['nombre']));

        return back()->with('success', 'Cliente creado correctamente');
    }

    public function actualizarCliente(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->only(['nombre']));

        return back()->with('success', 'Cliente actualizado correctamente');
    }

    public function eliminarCliente($id)
    {
        Cliente::destroy($id);
        return back()->with('success', 'Cliente eliminado correctamente');
    }
}

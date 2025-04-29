<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller; 
use App\Models\Metrica; // 👈 importante para acceder al usuario


class ConsultaController extends Controller
{ 
public function consultaMetricas()
{
    $user = Auth::user();

    // Verificar que sea tipo especial
    if (!$user || $user->tipo !== 'especial') {
        abort(403, 'No autorizado.');
    }
// Ordenar por fecha más reciente
$metricas = Metrica::where('referencia', $user->nombre)
->orderBy('created_at', 'desc')
->get();

    return view('consulta', compact('metricas'));
}

}
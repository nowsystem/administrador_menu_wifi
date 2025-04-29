<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            Panel de Administración
        </h2>
    </x-slot>

    <div class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="text-center">
            <h3 class="mb-4">Bienvenido al Panel de Administración</h3>

            @if(auth()->user()->tipo === 'administrador')
                <a href="{{ route('control.editar') }}" class="btn btn-primary btn-lg">
                    Administrar Datos
                </a>
            @else
                <div class="alert alert-danger mt-4">
                    Acceso restringido, solo administradores.
                </div>
            @endif
        </div>
    </div>
</x-layout>

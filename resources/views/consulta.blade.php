<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Datos de Usuarios Recibidas
        </h2>
    </x-slot>

    <div class="container mt-4">
        @if($metricas->isEmpty())
            <div class="alert alert-warning text-center">
                No se encontraron métricas.
            </div>
        @else
            <table class="table table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Comentarios</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($metricas as $metrica)
                        <tr>
                            <td>{{ $metrica->nombre }}</td>
                            <td>{{ $metrica->correo }}</td>
                            <td>{{ $metrica->telefono }}</td>
                            <td>{{ $metrica->comentarios }}</td>
                            <td>{{ $metrica->created_at->format('d/m/Y H:i') }}</td> <!-- fecha bonita -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-layout>

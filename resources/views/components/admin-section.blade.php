<div class="card mb-5 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
        <h5 class="mb-0">{{ $title }}</h5>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalCrear{{ ucfirst($type) }}">
            Agregar
        </button>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    @foreach(array_keys($items->first()->getAttributes()) as $key)
                        <th>{{ ucfirst($key) }}</th>
                    @endforeach
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        @foreach($item->getAttributes() as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                        <td>
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar{{ ucfirst($type) }}{{ $item->id }}">Editar</a>
                            <form action="{{ route('control.'.$type.'.eliminar', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Editar --}}
                    {{-- Aquí pondríamos el modal para editar --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Crear --}}
{{-- Aquí pondríamos el modal para crear --}}

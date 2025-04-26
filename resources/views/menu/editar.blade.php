<!-- resources/views/menu.blade.php -->

<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Gestión de Imágenes del Menú
        </h2>
    </x-slot>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif
        @if($menus->isEmpty())
        <div class="col-12">
            <div class="alert alert-warning text-center mt-4">
                No tiene imágenes que editar.
            </div>
        </div>
    @else
        <div class="row">
            @foreach($menus as $menu)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                    @if($menu->imagenes)
        <!-- Línea modificada: agregar parámetro anti-caché -->
        <img src="data:image/jpeg;base64,{{ base64_encode($menu->imagenes) }}" 
                     class="card-img-top"
                     alt="Imagen {{ $menu->id }}">
    @else
        <div class="card-body">
            <p class="text-muted">Sin imagen</p>
        </div>
    @endif
                        <div class="card-body text-center">
                            <h5 class="card-title">Imagen #{{ $menu->id }}</h5>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $menu->id }}">
                                Cambiar Imagen
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal para editar la imagen -->
                <div class="modal fade" id="modalEditar{{ $menu->id }}" tabindex="-1" aria-labelledby="modalEditarLabel{{ $menu->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('menu.actualizar', $menu->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditarLabel{{ $menu->id }}">Actualizar Imagen</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-2">Imagen actual:</p>
                                    @if($menu->imagenes)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($menu->imagenes) }}" class="img-fluid mb-3 rounded shadow-sm">
                                    @else
                                        <p>No hay imagen actual.</p>
                                    @endif
                                    <div class="mb-3">
                                        <label for="nueva_imagen{{ $menu->id }}" class="form-label">Selecciona una nueva imagen</label>
                                        <input type="file" name="nueva_imagen" id="nueva_imagen{{ $menu->id }}" accept=".jpg,image/jpeg" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                  
                                    <button type="submit" class="btn btn-success">Actualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
        </div>
    </div>
</x-layout>

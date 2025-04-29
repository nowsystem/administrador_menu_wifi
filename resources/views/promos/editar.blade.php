<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
         Promociones
        </h2>
    </x-slot>

    <div class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            @if($promos->isEmpty())
                <div class="col-12 text-center">
                    <div class="alert alert-warning mt-4">
                        No tienes promociones que editar.
                    </div>
                    <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">
                        Agregar Promoción
                    </button>
                </div>
            @else
                <div class="row justify-content-center">
                    @foreach($promos as $promo)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm">
                                @if($promo->imagenes)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($promo->imagenes) }}" 
                                        class="card-img-top" 
                                        alt="Promo {{ $promo->id }}">
                                @else
                                    <div class="card-body">
                                        <p class="text-muted text-center">Sin imagen</p>
                                    </div>
                                @endif
                                <div class="card-body text-center">
                                    <h5 class="card-title">Promocion #</h5>
                                    <button class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $promo->id }}">
                                        Cambiar Imagen
                                    </button>

                                    <form action="{{ route('promos.eliminar', $promo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro que quieres eliminar esta promoción?');">
                                         @csrf 
                                           @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Eliminar</button>   
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Editar -->
                        <div class="modal fade" id="modalEditar{{ $promo->id }}" tabindex="-1" aria-labelledby="modalEditarLabel{{ $promo->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('promos.actualizar', $promo->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditarLabel{{ $promo->id }}">Actualizar Imagen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if($promo->imagenes)
                                                <p class="mb-2">Imagen actual:</p>
                                                <img src="data:image/jpeg;base64,{{ base64_encode($promo->imagenes) }}" class="img-fluid mb-3 rounded shadow-sm">
                                            @else
                                                <p>No hay imagen actual.</p>
                                            @endif
                                            <div class="mb-3">
                                                <label for="nueva_imagen{{ $promo->id }}" class="form-label">Selecciona nueva imagen</label>
                                                <input type="file" name="nueva_imagen" id="nueva_imagen{{ $promo->id }}" accept=".jpg,image/jpeg" class="form-control" required>
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
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Agregar Nueva Promo -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('promos.crear') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarLabel">Nueva Promoción</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="nombre" value="{{ auth()->id() }}">
                        <div class="mb-3">
                            <label for="nueva_imagen" class="form-label">Selecciona imagen (JPG)</label>
                            <input type="file" name="nueva_imagen" id="nueva_imagen" accept=".jpg,image/jpeg" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar Promoción</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
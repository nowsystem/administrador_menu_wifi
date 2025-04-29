<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Administración Menu Wifi-QR
        </h2>
        <h3 class="text-center">Usuarios, Menús, Promociones y Clientes</h3>
    </x-slot>

    <div class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success text-center fixed-top mt-5" role="alert" style="width: 300px; margin: 0 auto; z-index: 1050;">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function(){
                        document.querySelector('.alert-success').remove();
                    }, 3000);
                </script>
            @endif

            <div class="my-4 p-4 rounded shadow-sm" style="background-color: #f8fafc;">
                <h4 class="text-center text-primary mb-3">USUARIOS</h4>
                <div class="d-flex justify-content-end mb-3">
                    <a href="#crearUsuarioModal" class="btn btn-success" data-bs-toggle="modal">Agregar Usuario</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->tipo }}</td>
                                <td class="text-center">
                                    <a href="#editarUsuarioModal{{ $user->id }}" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal">Editar</a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('control.users.eliminar', $user->id) }}', 'usuario', '{{ $user->name }}')">Eliminar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="crearUsuarioModalLabel">Agregar Usuario</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('control.users.crear') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Definicion</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo</label>
                                    <select class="form-select" id="tipo" name="tipo" required>
                                        <option value="admin">Administrador</option>
                                        <option value="normal" >Normal</option>
                                        <option value="especial">Especial</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($users as $user)
            <div class="modal fade" id="editarUsuarioModal{{ $user->id }}" tabindex="-1" aria-labelledby="editarUsuarioModalLabel{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title" id="editarUsuarioModalLabel{{ $user->id }}">Editar Usuario</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <form action="{{ route('control.users.actualizar', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nombre{{ $user->id }}" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="definicion{{ $user->id }}" class="form-label">Definicion</label>
                                    <input type="text" class="form-control" id="definicion{{ $user->id }}" name="nombre" value="{{ $user->nombre }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email{{ $user->id }}" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tipo{{ $user->id }}" class="form-label">Tipo de Usuario</label>
                                    <select class="form-select" id="tipo{{ $user->id }}" name="tipo" required>
                                        <option value="admin" {{ $user->tipo == 'admin' ? 'selected' : '' }}>Administrador</option>
                                        <option value="normal" {{ $user->tipo == 'normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="especial" {{ $user->tipo == 'especial' ? 'selected' : '' }}>Especial</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="password{{ $user->id }}" class="form-label">Nueva Contraseña (opcional)</label>
                                    <input type="password" class="form-control" id="password{{ $user->id }}" name="password">
                                    <small class="text-muted">Si no deseas cambiar la contraseña, deja este campo vacío.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="my-4 p-4 rounded shadow-sm" style="background-color: #e0f7fa;">
                <h4 class="text-center text-primary mb-3">IMAGENES DE MENU</h4>
                <div class="d-flex justify-content-end mb-3">
                    <a href="#crearMenuModal" class="btn btn-success" data-bs-toggle="modal">Agregar Imagenes</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Definicion</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                            <tr>
                                <td>{{ $menu->nombre }}</td>
                                <td class="text-center">
        <button class="btn btn-sm btn-info me-2" onclick="openMenuImagesModal('{{ $menu->id }}', '{{ $menu->nombre }}', {!! json_encode([$menu->imagenes]) !!})">
                   Ver Imágenes
        </button>
                                    <a href="#editarMenuModal{{ $menu->id }}" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal">Editar</a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('control.menus.eliminar', $menu->id) }}', 'menú', '{{ $menu->nombre }}')">Eliminar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="crearMenuModal" tabindex="-1" aria-labelledby="crearMenuModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="crearMenuModalLabel">Agregar Menú</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('control.menus.crear') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Definicion</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="imagenes" class="form-label">Imagen</label>
                                    <input type="file" class="form-control" id="imagenes" name="imagenes" required>
                                </div>
                                <div class="mb-3">
                                    <label for="canva" class="form-label">URL Canva</label>
                                    <input type="url" class="form-control" id="canva" name="canva" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($menus as $menu)
            <div class="modal fade" id="editarMenuModal{{ $menu->id }}" tabindex="-1" aria-labelledby="editarMenuModalLabel{{ $menu->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('control.menus.actualizar', $menu->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title" id="editarMenuModalLabel{{ $menu->id }}">Editar Menú</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Definición</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $menu->nombre }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="imagenes" class="form-label">Imagen (opcional)</label>
                                    <input type="file" class="form-control" id="imagenes" name="imagenes">
                                    <small class="text-muted">Sube una nueva imagen solo si deseas reemplazarla.</small>
                                    @if($menu->imagenes)
                                        <div class="mt-2">
                                            <img src="data:image/jpeg;base64,{{  base64_encode($menu->imagenes)}}" class="img-fluid" width="100">
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="canva" class="form-label">URL Canva</label>
                                    <input type="url" class="form-control" id="canva" name="canva" value="{{ $menu->canva }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="my-4 p-4 rounded shadow-sm" style="background-color: #f3e5f5;">
                <h4 class="text-center text-primary mb-3">PROMOCIONES</h4>
                <div class="d-flex justify-content-end mb-3">
                    <a href="#crearPromoModal" class="btn btn-success" data-bs-toggle="modal">Agregar Promoción</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promos as $promo)
                            <tr>
                                <td>
                                    @if($promo->imagenes)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($promo->imagenes) }}" class="img-fluid" width="100">

                                    @else
                                        <p>No hay imagen</p>
                                    @endif
                                </td>
                                <td>{{ $promo->nombre ?? 'Sin nombre' }}</td>
                                <td class="text-center">
                                    <a href="#editarPromoModal{{ $promo->id }}" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal">Editar</a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('control.promos.eliminar', $promo->id) }}', 'promoción', '{{ $promo->nombre }}')">Eliminar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="crearPromoModal" tabindex="-1" aria-labelledby="crearPromoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="crearPromoModalLabel">Agregar Promoción</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('control.promos.crear') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="imagenes" class="form-label">Imagen</label>
                                    <input type="file" class="form-control" id="imagenes" name="imagenes" required>
                                </div>
                                <div
                                    <label for="nombre" class="form-label"> Nombre (opcional)</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($promos as $promo)
            <div class="modal fade" id="editarPromoModal{{ $promo->id }}" tabindex="-1" aria-labelledby="editarPromoModalLabel{{ $promo->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title" id="editarPromoModalLabel{{ $promo->id }}">Editar Promoción</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('control.promos.actualizar', $promo->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="mb-3">
                                    <label for="imagenes" class="form-label">Imagen (opcional)</label>
                                    <input type="file" class="form-control" id="imagenes" name="imagenes">
                                    @if($promo->imagenes)
                                        <div class="mt-2">
                                            <img src="data:image/jpeg;base64,{{ $promo->imagenes }}" class="img-fluid" width="100">
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre (opcional)</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $promo->nombre }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="my-4 p-4 rounded shadow-sm" style="background-color: #c8e6c9;">
                <h4 class="text-center text-primary mb-3">CLIENTES</h4>
                <div class="d-flex justify-content-end mb-3">
                    <a href="#crearClienteModal" class="btn btn-success" data-bs-toggle="modal">Agregar Cliente</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Nombre</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->nombre }}</td>
                                <td class="text-center">
                                    <a href="#editarClienteModal{{ $cliente->id }}" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal">Editar</a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('control.clientes.eliminar', $cliente->id) }}', 'cliente', '{{ $cliente->nombre }}')">Eliminar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="crearClienteModal" tabindex="-1" aria-labelledby="crearClienteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="crearClienteModalLabel">Agregar Cliente</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('control.clientes.crear') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($clientes as $cliente)
            <div class="modal fade" id="editarClienteModal{{ $cliente->id }}" tabindex="-1" aria-labelledby="editarClienteModalLabel{{ $cliente->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title" id="editarClienteModalLabel{{ $cliente->id }}">Editar Cliente</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('control.clientes.actualizar', $cliente->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cliente->nombre }}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

      <!-- Modal para mostrar imágenes -->
<div class="modal fade" id="menuImagesModal" tabindex="-1" aria-labelledby="menuImagesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuImagesModalLabel">Imágenes del Menú</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="menuImagesContainer">
                <!-- Aquí se insertarán las imágenes dinámicamente -->
            </div>
        </div>
    </div>
</div>



            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <p><span id="deleteConfirmationMessage"></span></p>
                            <form id="deleteForm" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

      
               <script>

function openMenuImagesModal(menuId, menuNombre, menuImagenes) {
    const modal = new bootstrap.Modal(document.getElementById('menuImagesModal'));
    const container = document.getElementById('menuImagesContainer');
    container.innerHTML = ''; // Limpiar contenido anterior
    document.getElementById('menuImagesModalLabel').innerText = `Imágenes del Menú: ${menuNombre}`;

    if (menuImagenes && Array.isArray(menuImagenes) && menuImagenes.length > 0) {
        menuImagenes.forEach(function(imagenBinaria) {
            if (imagenBinaria) {
                const img = document.createElement('img');
                img.src = `data:image/jpeg;base64,${btoa(imagenBinaria)}`;
                img.className = 'img-fluid m-2 rounded';
                img.style.maxWidth = '150px';
                img.style.maxHeight = '150px';
                container.appendChild(img);
            }
        });
    } else {
        container.innerHTML = '<p class="text-center text-muted">No hay imágenes para mostrar.</p>';
    }

    modal.show();
}

              // modal borrar

                function confirmDelete(url, tipo, nombre) {
                    const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                    const message = document.getElementById('deleteConfirmationMessage');
                    const deleteForm = document.getElementById('deleteForm');
                    deleteForm.action = url;
                    message.innerText = `¿Estás seguro de eliminar este ${tipo} ${nombre ? '"' + nombre + '"' : ''}?`;
                    modal.show();
                }
            </script>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</x-layout>
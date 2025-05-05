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

            @php
                $tipo = auth()->user()->tipo ?? null;
                $isImageUser = in_array($tipo, ['normal', 'especial']);
            @endphp

            @if($promos->isEmpty())
                <div class="col-12 text-center">
                    <div class="alert alert-warning mt-4">
                        No tienes promociones que editar.
                    </div>
                    <button class="btn btn-outline-primary mt-3" 
                            data-bs-toggle="modal" 
                            data-bs-target="{{ $isImageUser ? '#modalAgregar' : '#modalLabel' }}">
                        Agregar Promoción
                    </button>
                </div>
            @else
                <div class="row justify-content-center">
                    @foreach($promos as $promo)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm">
                                @if($isImageUser && $promo->imagenes)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($promo->imagenes) }}"
                                         class="card-img-top"
                                         alt="Promo {{ $promo->id }}">
                                @else
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $promo->label }} {{ $promo->emoji }}</h5>
                                    </div>
                                @endif
                                <div class="card-body text-center">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-primary mb-2" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modal{{ $isImageUser ? 'Editar' : 'Texto' }}{{ $promo->id }}">
                                            {{ $isImageUser ? 'Cambiar Imagen' : 'Editar Promo o Video' }}
                                        </button>
                                        
                                        <form action="{{ route('promos.eliminar', $promo->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" 
                                                    onclick="return confirm('¿Estás seguro de eliminar esta promoción?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modales de Edición -->
                        @if($isImageUser)
                            <!-- Modal Editar Imagen -->
                            <div class="modal fade" id="modalEditar{{ $promo->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('promos.actualizar', $promo->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Actualizar Imagen</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if($promo->imagenes)
                                                    <img src="data:image/jpeg;base64,{{ base64_encode($promo->imagenes) }}" 
                                                         class="img-fluid mb-3">
                                                @endif
                                                <div class="mb-3">
                                                    <input type="file" name="nueva_imagen" class="form-control" accept="image/jpeg" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Actualizar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Modal Editar Texto -->
                            <div class="modal fade" id="modalTexto{{ $promo->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('promos.actualizar.texto', $promo->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Editar Texto Promocional</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="text" name="label" class="form-control" 
                                                           value="{{ $promo->label }}" maxlength="60" required>
                                                </div>
                                                <div class="mb-3">
                                                    <select name="emoji" class="form-select">
                                                        @foreach(['🍕', '🔥', '🎉', '❤️', '😋', '💥'] as $emoji)
                                                            <option value="{{ $emoji }}" {{ $promo->emoji == $emoji ? 'selected' : '' }}>{{ $emoji }}</option>
                                                        @endforeach
                                                    </select>
     
                                                    @if ($promo->video)
    <div class="mb-3">
        <label class="form-label">Video actual:</label>
        <div class="ratio ratio-16x9">
            <video controls>
                <source src="{{ asset('storage/videos/' . $promo->video) }}" type="video/mp4">
                Tu navegador no soporta videos HTML5.
            </video>
        </div>
    </div>
@endif

<div class="mb-3">
    <label for="nuevo_video" class="form-label">Cambiar video (opcional)</label>
    <input type="file" name="video" id="nuevo_video" class="form-control" accept="video/mp4">
</div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Modales de Agregar -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('promos.crear') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Nueva Promoción</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="nombre" value="{{ auth()->id() }}">
                        <div class="mb-3">
                            <input type="file" name="nueva_imagen" class="form-control" accept="image/jpeg" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLabel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('promos.label') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Texto Promocional</h5>
                        <input type="hidden" name="nombre" value="{{ auth()->id() }}">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" name="label" class="form-control" placeholder="Texto promocional" maxlength="60" required>
                        </div>
                        <div class="mb-3">
                            <select name="emoji" class="form-select">         
<option value="🍔">🍔 Hamburguesa</option>
<option value="🍟">🍟 Papas fritas</option>
<option value="🌮">🌮 Taco</option>
<option value="🌯">🌯 Burrito</option>
<option value="🍝">🍝 Espagueti</option>
<option value="🍜">🍜 Fideos</option>
<option value="🍛">🍛 Curry</option>
<option value="🍲">🍲 Sopa</option>
<option value="🥘">🥘 Paella</option>
<option value="🍤">🍤 Camarón</option>
<option value="🍥">🍥 Pastel de pescado</option>
<option value="🍢">🍢 Brocheta</option>
<option value="🍡">🍡 Dango</option>
<option value="🍧">🍧 Granizado</option>
<option value="🍨">🍨 Helado</option>
<option value="🍦">🍦 Cono de helado</option>
<option value="🥧">🥧 Pay</option>
<option value="🧁">🧁 Cupcake</option>
<option value="🎂">🎂 Pastel de cumpleaños</option>
<option value="🍰">🍰 Pastel</option>
<option value="🍪">🍪 Galleta</option>
<option value="🥛">🥛 Leche</option>
<option value="☕">☕ Café</option>
<option value="🍵">🍵 Té</option>
<option value="🧃">🧃 Jugo</option>
<option value="🧋">🧋 Té con burbujas</option>
<option value="🥃">🥃 Whisky</option>
<option value="🧉">🧉 Mate</option>
<option value="🍾">🍾 Champán</option>
<option value="🥐">🥐 Croissant</option>
<option value="🥨">🥨 Pretzel</option>
<option value="🥯">🥯 Bagel</option>
<option value="🥞">🥞 Panqueques</option>
<option value="🧇">🧇 Waffle</option>
<option value="🌭">🌭 Hot dog</option>
<option value="🍿">🍿 Palomitas</option>
<option value="🧈">🧈 Mantequilla</option>
<option value="🥫">🥫 Conserva</option>
<option value="🥟">🥟 Dumplings</option>
<option value="🥠">🥠 Galleta de la fortuna</option>
<option value="🥓">🥓 Tocino</option>
<option value="🥩">🥩 Carne roja</option>
<option value="🍗">🍗 Pollo asado</option>
<option value="🍖">🍖 Costilla</option>
<option value="🥚">🥚 Huevo</option>
<option value="🥒">🥒 Pepino</option>
<option value="🥬">🥬 Col rizada</option>
<option value="🥦">🥦 Brócoli</option>
<option value="🧄">🧄 Ajo</option>
<option value="🧅">🧅 Cebolla</option>
<option value="🥔">🥔 Papa</option>
<option value="🍠">🍠 Camote</option>
<option value="🥜">🥜 Maní</option>
<option value="🌰">🌰 Castaña</option>
<option value="🥥">🥥 Coco</option>
<option value="🫒">🫒 Aceituna</option>
<option value="🫑">🫑 Pimiento</option>
<option value="🌶️">🌶️ Chile</option>
<option value="🥭">🥭 Mango</option>
<option value="👍">👍 Pulgar arriba</option>
<option value="👎">👎 Pulgar abajo</option>
<option value="👏">👏 Aplausos</option>
<option value="🙌">🙌 Celebración</option>
<option value="🤝">🤝 Apretón de manos</option>
<option value="✌️">✌️ Victoria</option>
<option value="🤘">🤘 Cuernitos (rock)</option>
<option value="🤙">🤙 Llámame</option>
<option value="👌">👌 Perfecto</option>
<option value="🤏">🤏 Pellizco</option>
<option value="👋">👋 Adiós</option>
<option value="👐">👐 Manos abiertas</option>
<option value="🙏">🙏 Por favor</option>
<option value="🤳">🤳 Selfie</option>
<option value="👂">👂 Escuchando</option>
<option value="👀">👀 Vigilante</option>
<option value="💋">💋 Beso</option>
<option value="🤦">🤦 Facepalm</option>
<option value="🙅">🙅 Prohibido</option>
<option value="💃">💃 Bailarina</option>
                            </select>
                        </div>
                        <div class="mb-3">
                <label for="video">Subir video promocional (opcional, MP4, máx. 4MB):</label>
                <input type="file" name="video" class="form-control" accept="video/mp4" />
            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }
        .form-select option {
            font-size: 1.2em;
        }
    </style>
</x-layout>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ ucfirst($pageName) }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #000;
            margin: 0;
            padding: 0;
            color: white;
        }

        .img-kabuky {
            display: block;
            max-width: 100%; /* Asegura que las imágenes no se salgan del contenedor */
            height: auto;
            border-radius: 5px;
            margin: 0 auto;
        }

        .image-wrapper {
            padding: 0;
            margin: 0;
        }

        .footer-bottom {
            background: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 40px;
        }

        .footer-bottom a {
            color: #f1f1f1;
            text-decoration: none;
        }

        .footer-bottom a:hover {
            text-decoration: underline;
        }

        .promo {
            margin-top: 40px;
            text-align: center;
        }

        .promo img {
            max-width: 100%; /* Asegura que las imágenes de promo tengan el mismo tamaño */
            height: auto;
            border-radius: 5px;
        }

        /* Establecer un ancho máximo para las imágenes de la galería y de la promo */
        .foto img, .promo img {
            max-width: 1200px; /* Puedes ajustar este valor para que sea el tamaño que desees */
        }
    </style>
</head>
<body>

    <div class="container-fluid p-0">

        <div class="container text-center my-5">
           

            <!-- Galería de imágenes -->
            <div class="row justify-content-center">
                @forelse ($imagenes as $imagen)
                <div class="promo">
                       
                            <img src="data:image/jpeg;base64,{{ base64_encode($imagen) }}" alt="Imagen de {{ $pageName }}" class="img-kabuky">
                        
                    </div>
                @empty
                    <p>No hay imágenes disponibles.</p>
                @endforelse
            </div>

            {{-- Promo abajo de todo --}}
        @if($promo && $promo->imagenes)
            <div class="promo">
               
                <img src="data:image/jpeg;base64,{{ base64_encode($promo->imagenes) }}" alt="" class="img-kabuky">
            </div>
        @endif
        </div>
        @if (!$tipoNormal)
    <div class="container my-5 d-flex justify-content-center">
        <div class="card shadow p-4" style="max-width: 600px; width: 100%;">
            <h2 class="text-center mb-4">Tu comentario es importante</h2>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Errores de validación --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('guardar.metrica', ['pageName' => $pageName]) }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Email</label>
                    <input type="email" name="correo" id="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo') }}" required>
                    @error('correo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" required>
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="comentario" class="form-label">Comentario</label>
                    <textarea name="comentarios" id="comentarios" class="form-control @error('comentarios') is-invalid @enderror" rows="3" >{{ old('comentarios') }}</textarea>
                    @error('comentario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Enviar</button>
                </div>
            </form>
        </div>
    </div>
@endif


    </div>

    <!-- Footer -->
    <div class="footer-bottom">
        <div class="copyright">
            &copy; Copyright <strong><span>NOWSYSTEM</span></strong>. All Rights Reserved Quito 2025
        </div>
        <div class="credits">
            Designed by <a href="https://www.nowsystem.net" target="_blank">Nowsystem</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

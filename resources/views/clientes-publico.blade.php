<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kabuky</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #000;
            margin: 0;
            padding: 0;
        }

        .img-kabuky {
            display: block;
            max-width: 100%;
            height: auto;
            border-radius: 0;
            margin: 0 auto;
        }

        .image-wrapper {
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="container-fluid p-0">
        @foreach($imagenes as $img)
            <div class="row justify-content-center image-wrapper">
                <div class="col-12 col-md-10 p-0">
                    <img src="data:image/jpeg;base64,{{ base64_encode($img->imagenes) }}" 
                         class="img-kabuky" 
                         alt="Imagen del menú Kabuky">
                </div>
            </div>
        @endforeach
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>NOWSYSTEM</span></strong>. All Rights Reserved Quito 2025
      </div>
      <div class="credits">
        
        Designed by <a href="https://www.nowsystem.net">Nowsystem</a>
      </div>
    </div>
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

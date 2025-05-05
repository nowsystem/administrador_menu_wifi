{{-- resources/views/screen/tv.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title> {{ $pageName }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: black;
        }
    </style>
</head>
<body>
    @include("screen.$vistaAsignada", ['imagenes' => $imagenes, 'pageName' => $pageName])
</body>
</html>

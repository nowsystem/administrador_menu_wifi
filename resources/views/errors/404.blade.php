<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error 404</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: 'Segoe UI', sans-serif;
            text-align: center;
            padding: 50px;
        }
        h1 {
            font-size: 80px;
            color: #3490dc;
        }
        p {
            font-size: 24px;
        }
        a {
            color: #3490dc;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>404</h1>
    <p>La página que buscas no existe.</p>
    <a href="{{ url('/') }}">Volver al inicio</a>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a Menu Wifi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(to bottom right, #111827, #0f172a);
            color: #f8f9fa;
            overflow-x: hidden;
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .gradient-text {
            background: linear-gradient(45deg, #4ade80, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .glass-card {
            background: rgba(31, 41, 55, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 1.25rem;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .btn-glass {
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-glass-green {
            background: linear-gradient(to right, #22c55e, #10b981);
            color: white;
        }

        .btn-glass-green:hover {
            background: linear-gradient(to right, #16a34a, #059669);
            transform: translateY(-3px);
        }

        .btn-glass-dark {
            background-color: #1f2937;
            color: white;
        }

        .btn-glass-dark:hover {
            background-color: #374151;
            transform: translateY(-3px);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center p-4">

    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iNSIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIvPjwvc3ZnPg=='); z-index: 0;"></div>

    <div class="container position-relative z-1 text-center">
        <div class="floating mb-4">
            <img src="{{ asset('images/logo_empresa.png') }}" alt="Logo Menu Wifi" class="rounded-4 shadow" style="height: 100px; width: 100px;">
        </div>

        <h1 class="gradient-text fw-bold display-4 mb-3">Menu Wifi</h1>
        <p class="text-light fs-5 mb-5">
           Panel administrativo Sistema de Menú Wifi
        </p>

        <div class="glass-card mx-auto text-center" style="max-width: 600px;">
            <p class="fs-6 mb-4 text-white-50">
                Únete a la revolución digital y lleva la experiencia de tus clientes al siguiente nivel.
            </p>

            <div class="d-grid gap-3 d-md-flex justify-content-center">
                <a href="{{ route('register') }}" class="btn btn-glass btn-glass-green">
                    Crear cuenta gratis
                </a>
                <a href="{{ route('login') }}" class="btn btn-glass btn-glass-dark">
                    Iniciar sesión
                </a>
            </div>

            <p class="text-muted small mt-4">Comienza en minutos • Sin tarjeta requerida</p>
        </div>

      
    </div>

</body>
</html>

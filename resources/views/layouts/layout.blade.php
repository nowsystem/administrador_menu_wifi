<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','TV App')</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @stack('styles')
</head>
<body style="margin:0;padding:0;background:#000;color:#fff;font-family:'Segoe UI',sans-serif;">
  @yield('content')
  <script src="{{ asset('js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>

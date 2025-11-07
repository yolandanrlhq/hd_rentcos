<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'HDRENTCOS Dashboard')</title>
  <link rel="stylesheet" href="{{ asset('css/berandaAdmin.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/berandaAdmin.css') }}">
  @yield('extra-css')
</head>
<body>
      @yield('content')
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="https://laravel.com/img/favicon/favicon.ico" />
  <title>Daily Sphere</title>
  @vite('resources/js/app.js')
</head>

<body class="bg-light">
  <x-topbar />

  <main class="position-relative d-flex align-items-stretch">
    @auth <x-sidebar /> @endauth

    <div class="site-content container-fluid">
      {{ $slot }}
    </div>
  </main>

  <x-flash-message />
  <x-feature-003 />
</body>

</html>

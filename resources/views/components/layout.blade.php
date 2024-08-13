<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="robots" content="nofollow">

    <title>{{ config('app.name', 'EduHub') }}</title>

    <link rel="manifest" href="/site.webmanifest" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js" integrity="sha512-nnzkI2u2Dy6HMnzMIkh7CPd1KX445z38XIu4jG1jGw7x5tSL3VBjE44dY4ihMU1ijAQV930SPM12cCFrB18sVw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="/css/font.css" rel="stylesheet" />
    <link href="/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="/bootstrap/icons/bootstrap-icons.min.css" rel="stylesheet" >
    <script src="/jquery/jquery-3.7.1.min.js"></script>
    <script src="/bootstrap/masonry.pkgd.min.js"></script>
    <script src="/bootstrap/bootstrap.min.js"></script>

    <link href="/css/app.css" rel="stylesheet" />
    <script src="/js/app.js"></script>
    <script>
        document.documentElement.setAttribute('data-bs-theme', localStorage.getItem('bsTheme') || 'light');
    </script>
</head>
<body>
    <x-toast />
    <main>
        {{ $slot }}
    </main>
</body>
<script>
    $(document).ready(function () {
        $(".toast").toast("show");
        updateTheme();
    });
</script>
</html>

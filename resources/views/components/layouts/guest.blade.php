<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Poliklinik' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        crossorigin="anonymous" />

    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .brand-serif {
            font-family: 'Instrument Serif', serif;
        }
    </style>
</head>

<body
    style="min-height:100vh;background:linear-gradient(135deg,#1e2d6b 0%,#2d4499 60%,#1a2d7a 100%);display:flex;align-items:center;justify-content:center;padding:24px;">

    {{ $slot }}
    @stack('scripts')
</body>

</html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    {{-- Tailwind CSS --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Font Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    {{-- Fancybox --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />

    {{-- AOS CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    {{-- ReCAPTCHA
    {!! ReCaptcha::htmlScriptTagJsApi() !!} --}}

</head>

<body class="font-inter">

    @include('partials.navbar')

    @yield('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            AOS.init();
            const cardSlider = new Carousel(document.querySelector("#cardSlider"), {
                Dots: false,
            });
        });
    </script>
    
    {{-- @include('partials.footer') --}}
</body>

</html>
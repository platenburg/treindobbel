<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Waar ga jij vandaag heen?</title>

    <meta name="title" content="{{ config('app.name') }}">
    <meta name="description" content="Dobbel en vind een treinreis vanuit elk station in Nederland.">
    <meta name="keywords" content="trein, reizen, ns, station, dobbel, willekeurig, treinen, dobbelen, spel">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="language" content="{{ config('app.locale') }}">

    @stack('meta')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <x-plausible-script />
</head>

<body class="bg-yellow-500">
    <div class="container px-4 py-4 mx-auto text-center">
        @yield('content')
    </div>

    {{-- Force footer downwards --}}
    <footer>
        <div class="absolute bottom-0 w-full text-center">
            &copy; {{ date('Y') }} - {{ config('app.name') }}<br>
            <small>{{ config('app.name') }} is niet verantwoordelijk voor onjuiste reisinformatie.</small>
        </div>
    </footer>
</body>

@stack('scripts')

</html>

<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

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
            <small>{{ config('app.name') }} is niet verantwoordelijk voor onjuiste reisinformatie.<br>Reisinformatie via
                NS.</small>
        </div>
    </footer>
</body>

@stack('scripts')

</html>

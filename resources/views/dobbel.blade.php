@extends('layout')

@push('meta')
    <meta property="og:type" content="website">
    @if ($departure !== null)
        <meta property="og:title" content="TreinDobbel vanaf station {{ $departure['departureStation'] }}">
    @else
        <meta property="og:title" content="TreinDobbel">
    @endif
    <meta property="og:url" content="https://treindobbel.nl">
    <meta property="og:description" content="Dobbel en vind een treinreis vanuit elk station in Nederland.">
@endpush

@section('content')
    @if ($departure !== null)
        <h2 class="text-3xl font-bold text-blue-900">Je gaat naar...</h2>
    @else
        <h2 class="text-3xl font-bold text-blue-900">Jammer...</h2>
    @endif

    <div class="mt-8">
        @if ($departure !== null)
            <h1 class="text-4xl font-bold">station {{ $departure['stationName'] }}</h1>
            <h2 class="mt-4 text-2xl">met de <b>{{ $departure['departureType'] }}</b> richting
                <b>{{ $departure['departureDirection'] }}</b>
            </h2>

            <h3 class="mt-2 text-2xl">die vertrekt @if ($departure['departureTrack'])
                    vanaf <b>spoor
                        {{ $departure['departureTrack'] }}</b>
                @endif om
                <b>{{ \Carbon\Carbon::parse($departure['departureTime'])->setTimezone(config('app.timezone'))->format('H:i') }}
                    uur</b>
            </h3>

            <a href="{{ route('dobbel', ['station' => $departure['stationUic']]) }}"
                class="block p-4 mt-8 text-blue-900 bg-white rounded-lg">En nu?<br>Vind een trein vanuit
                {{ $departure['stationName'] }}</a>
            <a href="{{ route('dobbel', ['station' => $departure['departureStation']]) }}"
                class="block p-4 mt-2 text-white bg-blue-900 rounded-lg">Ik wil ergens anders heen</a>

            <p class="mt-2 text-xl">Je vertrekt vanaf station <b>{{ $departure['departureStationName'] }}</b>.</p>
        @else
            <p class="mt-2 text-xl">Er komt binnenkort geen trein meer op dit station.
                <br>Probeer het op een ander station, of kijk op de NS app of op <a href="https://www.ns.nl"
                    class="text-blue-900 underline">ns.nl</a> voor actuele reisinformatie.
            </p>
        @endif

        <a href="{{ route('home') }}" class="mt-4 text-lg text-blue-900 underline">Beginnen op een ander station?</a>
    </div>
@endsection

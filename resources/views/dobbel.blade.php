@extends('layout')

@section('content')
    <h2 class="text-3xl font-bold text-blue-900">Je gaat naar...</h2>

    <div class="mt-8">
        @if ($departure !== null)
            <h1 class="text-4xl font-bold">station {{ $departure['stationName'] }}</h1>
            <h2 class="mt-4 text-2xl">met de <b>{{ $departure['departureType'] }}</b> richting
                <b>{{ $departure['departureDirection'] }}</b>
            </h2>

            <div class="mt-8">
                <h3 class="mt-4 text-2xl">die vertrekt vanaf <b>spoor
                        {{ $departure['departureTrack'] }}</b> om
                    <b>{{ \Carbon\Carbon::parse($departure['departureTime'])->setTimezone(config('app.timezone'))->format('H:i') }}
                        uur</b>
                </h3>
            </div>

            <a href="{{ route('dobbel', ['station' => $departure['stationUic']]) }}"
                class="block p-4 mt-8 text-blue-900 bg-white rounded-lg">En nu?<br>Vind een trein vanuit
                {{ $departure['stationName'] }}</a>
            <a href="{{ route('dobbel', ['station' => $departure['departureStation']]) }}"
                class="block p-4 mt-2 text-white bg-blue-900 rounded-lg">Ik wil ergens anders heen</a>
        @else
            <h2 class="text-3xl">Helaas.</h2>
            <p class="mt-2">Er is geen trein gevonden.</p>
        @endif

        <p class="mt-2 text-xl">Je vertrekt vanaf station <b>{{ $departure['departureStationName'] }}</b></p>
        <a href="{{ route('home') }}" class="text-lg text-blue-900 underline">Beginnen op een ander station?</a>
    </div>
@endsection
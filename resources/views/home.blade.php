@extends('layout')

@push('meta')
    <meta property="og:type" content="website">
    <meta property="og:title" content="TreinDobbel">
    <meta property="og:url" content="https://treindobbel.nl">
    <meta property="og:description" content="Dobbel en vind een treinreis vanuit elk station in Nederland.">
@endpush

@section('content')
    <h1 class="text-5xl font-bold text-blue-900">{{ config('app.name') }}</h1>

    <div class="mt-8">
        <h2 class="text-3xl font-bold">Waar begint je avontuur?</h2>
        <div class="mt-4">
            <select class="p-2 rounded-lg" id="station">

                @foreach ($stations as $station)
                    <option value="{{ $station->UICCode }}">{{ $station->namen->lang }}
                    </option>
                @endforeach
            </select>
        </div>

        <a id="dobbelButton" href="" class="block p-4 mt-8 text-white bg-blue-900 rounded-lg">Dobbel</a>

        <div class="mt-8">
            <h3 class="text-2xl font-bold">Hoe werkt {{ config('app.name') }}?</h3>
            <p class="mt-2 text-xl">Kies je vertrekstation uit de lijst, en klik op 'Dobbel'. Er zal dan uit de volgende 15
                treinen vanaf dat station één geselecteerd worden. Zodra je daar bent aangekomen, kan je verder vanaf dat
                station. Zo kan je goed een dag vullen met Nederland ontdekken!</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const stationSelect = document.querySelector('#station');
        let stationChoices = null;
        document.addEventListener("DOMContentLoaded", function() {
            stationChoices = new Choices("#station", {
                searchEnabled: true,
                itemSelectText: "",
                allowHTML: true,
            });
        });

        const updateURL = () => {
            const station = stationSelect.value;
            let url = "{{ route('dobbel', ['station' => 'STATION']) }}";
            url = url.replace('STATION', station);

            const dobbelButton = document.querySelector('#dobbelButton');
            dobbelButton.href = url;
        }

        stationSelect.addEventListener('change', updateURL);
        updateURL();

        // Ask for browser location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Make request to our API to fetch nearest station based on latitude and longitude
                fetch(`{{ route('api.nearest') }}?lat=${latitude}&lng=${longitude}`)
                    .then(response => response.json())
                    .then(data => {
                        const station = data;
                        stationChoices.setChoiceByValue(station.id.uicCode);

                        console.log("Nearest station: " + station.names.long, `(${station.id.uicCode})`);

                        const event = new Event('change');
                        stationSelect.dispatchEvent(event);
                    });
            });
        }
    </script>
@endpush

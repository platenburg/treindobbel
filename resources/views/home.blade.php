@extends('layout')

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

        stationSelect.addEventListener('change', () => {
            const station = stationSelect.value;
            let url = "{{ route('dobbel', ['station' => 'STATION']) }}";
            url = url.replace('STATION', station);

            const dobbelButton = document.querySelector('#dobbelButton');
            dobbelButton.href = url;
        });

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

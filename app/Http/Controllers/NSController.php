<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class NSController extends Controller
{
    public function getClosestStation($lat, $long) {
        $url = "https://gateway.apiportal.ns.nl/nsapp-stations/v3/nearest?lat=" . $lat . "&lng=" . $long;
        $station = $this->makeNSRequest($url)->payload;
        return $station[0];
    }

    public function getStations() {
        $stations = Cache::remember('stations', 1440, function() {
            // Get data from NS API
            $url = 'https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/stations';
            $stations = $this->makeNSRequest($url)->payload;

            // Eliminate all stations that do not have NL as land
            $stations = array_filter($stations, function($station) {
                return $station->land == 'NL';
            });

            return $stations;
        });
        return $stations;
    }

    public function getStationFromUic($uicCode) {
        $stations = $this->getStations();
        $station = array_filter($stations, function($station) use ($uicCode) {
            return $station->UICCode == $uicCode;
        });
        return reset($station);
    }

    public function getStationFromName($stationName) {
        $url = 'https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/stations?q=' . urlencode($stationName) . "&limit=1";
        $station = $this->makeNSRequest($url)->payload;
        return $station[0];
    }

    public function getDeparturesByUic($uicCode) {
        $url = 'https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/departures?uicCode=' . $uicCode . '&maxJourneys=15';
        $departures = $this->makeNSRequest($url)->payload;
        return $departures;
    }

    private function makeNSRequest($url) {
        $client = new Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'Ocp-Apim-Subscription-Key' => config('app.ns_key'),
            ],
        ]);

        return json_decode($response->getBody());
    }
}
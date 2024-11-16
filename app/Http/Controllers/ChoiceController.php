<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

class ChoiceController extends Controller
{
    public static function chooseTrain($startStationUic) {
        // Find the departures from the start station Uic
        $departures = (new NSController())->getDeparturesByUic($startStationUic);
        $departures = $departures->departures;

        // Eliminate all departures that do not have a routeStations property
        $departures = array_filter($departures, function($departure) {
            return isset($departure->routeStations) && !empty($departure->routeStations);
        });

        // Eliminate departures that have ->product->categoryCode == "BUS"
        $departures = array_filter($departures, function($departure) {
            return $departure->product->categoryCode != "BUS";
        });

        if(empty($departures)) {
            return null;
        }

        // Get a random departure
        $randomDeparture = $departures[array_rand($departures)];

        // Get a random station from the routeStations property
        $stations = $randomDeparture->routeStations;

        $randomStation = $randomDeparture->routeStations[array_rand($stations)];

        $randomStationData = (new NSController())->getStationFromName($randomStation->mediumName);

        // If the random station is not in the Netherlands, get a new random station
        while ($randomStationData->land != 'NL') {
            $randomStation = $randomDeparture->routeStations[array_rand($stations)];
            $randomStationData = (new NSController())->getStationFromName($randomStation->mediumName);
        }

        $startStationData = (new NSController())->getStationFromUic($startStationUic);

        $data = [
            'departureStation' => $startStationUic,
            'departureStationName' => $startStationData->namen->lang,
            'departureTrack' => $randomDeparture->actualTrack ?? null, // Sometimes, the actualTrack is not set yet
            'departureType' => $randomDeparture->product->shortCategoryName,
            'departureDirection' => $randomDeparture->direction,
            'departureTime' => $randomDeparture->actualDateTime,
            'stationName' => $randomStationData->namen->lang,
            'stationUic' => $randomStation->uicCode,
        ];

        return $data;
    }
}
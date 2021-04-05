<?php

namespace App\Http\Web\Controllers;

use App\Http\BaseController;
use App\Models\Aircraft;
use App\Models\AircraftType;
use App\Services\ShowAircraftService;

class HomeController extends BaseController
{
    public function index()
    {
        $aircraftTypes = AircraftType::all();

        $aircrafts = (new ShowAircraftService)->show();

        echo $this->renderHTML('home.twig', [
            'aircrafts' => $aircrafts,
            'sizes' => Aircraft::SIZES,
            'aircraftTypes' => $aircraftTypes
        ]);
    }
}

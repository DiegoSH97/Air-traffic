<?php

namespace App\Http\Web\Controllers;

use App\Http\BaseController;
use App\Models\Aircraft;
use App\Models\AircraftType;
use App\Services\DeleteAircraftService;
use App\Services\ShowAircraftService;
use App\Services\StoreAircraftService;

class AircraftController extends BaseController
{
    private $aircraftTypes;
    private $aircrafts;
    private $sizes;

    public function __construct()
    {
        parent::__construct();

        $this->aircraftTypes = AircraftType::all();
        $this->sizes = Aircraft::SIZES;
    }

    public function store($request)
    {
        $postData = $request->getParsedBody();

        (new StoreAircraftService)->store($postData);

        $this->aircrafts = (new ShowAircraftService)->show();
    
        echo $this->renderHTML('home.twig', [
            'aircrafts' => $this->aircrafts,
            'sizes' => $this->sizes,
            'aircraftTypes' => $this->aircraftTypes,
            'message' => 'Aircraft successuful stored',
        ]);
    }

    public function delete()
    {
        (new DeleteAircraftService)->delete();

        $this->aircrafts = (new ShowAircraftService)->show();

        echo $this->renderHTML('home.twig', [
            'aircrafts' => $this->aircrafts,
            'sizes' => $this->sizes,
            'aircraftTypes' => $this->aircraftTypes
        ]);
    }
}

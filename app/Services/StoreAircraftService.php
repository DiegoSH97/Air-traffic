<?php

namespace App\Services;

use App\Models\Aircraft;
use App\Models\AircraftType;
use App\Models\Exceptions\InvalidAircraftSizeException;

class StoreAircraftService
{
    public function store($data)
    {
        AircraftType::findOrFail($data['aircraft_type_id']);

        throw_if(!array_key_exists($data['size'], Aircraft::SIZES), new InvalidAircraftSizeException());

        $aircraft = new Aircraft();
        $aircraft->fill($data);
        $aircraft->save();

        return $aircraft;
    }
}

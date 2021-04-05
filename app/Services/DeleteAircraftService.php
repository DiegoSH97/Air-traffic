<?php

namespace App\Services;

use App\Models\Aircraft;

class DeleteAircraftService
{
    public function delete()
    {
        $aircraft = Aircraft::query()
            ->select('aircrafts.id', 'aircrafts.size', 'aircraft_types.description')
            ->join('aircraft_types', 'aircrafts.aircraft_type_id', 'aircraft_types.id')
            ->orderBy('aircraft_types.priority')
            ->orderBy('aircrafts.size', 'desc')
            ->firstOrFail();

        $aircraft->delete();
    }
}

<?php

namespace App\Http\Movil\Controllers;

use App\Models\Exceptions\InvalidAircraftSizeException;
use App\Services\DeleteAircraftService;
use App\Services\StoreAircraftService;
use App\Services\ShowAircraftService;
use Illuminate\Database\RecordsNotFoundException;

class AircraftController
{
    public function index()
    {
        $aircrafts = (new ShowAircraftService)->show();

        echo json_encode(array(
            'status' => 200,
            'object' => $aircrafts,
        ));
    }

    public function store($request)
    {
        $postData = $request->getParsedBody();
        
        try {
            $aircraft = (new StoreAircraftService)->store($postData);

            echo json_encode(array(
                'status' => 200,
                'message' => 'Successful: Aircraft saved',
                'object' => $aircraft,
            ));
        } catch (RecordsNotFoundException $exception) {
            echo json_encode(array(
                'status' => 404,
                'message' => $exception->getMessage()
            ));
        } catch (InvalidAircraftSizeException $exception) {
            echo json_encode(array(
                'status' => 422,
                'message' => $exception->get_message()
            ));
        } catch (\Exception $exception) {
            echo json_encode(array(
                'status' => 500,
                'message' => $exception->getMessage()
            ));
        }
    }

    public function delete()
    {
        try {
            (new DeleteAircraftService)->delete();

            echo json_encode(array(
                'status' => 200,
                'message' => 'Successful: Aircraft deleted',
                'object' => null,
            ));
        } catch (\Exception $exception) {
            echo json_encode(array(
                'status' => 500,
                'message' => $exception->getMessage()
            ));
        }
    }
}

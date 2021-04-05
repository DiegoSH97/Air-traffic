<?php

use App\Services\DeleteAircraftService;
use App\Services\ShowAircraftService;
use App\Services\StoreAircraftService;
use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;

class DeleteAircraftServiceTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();
        
        $dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__. '/../..');
        $dotenv->load();

        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => getenv('DB_HOST'),
            'database'  => getenv('DB_DATABASE'),
            'username'  => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function test_get_aircrafts()
    {
        $data = [
            'size' => 1,
            'aircraft_type_id' => 1
        ];

        (new StoreAircraftService)->store($data);

        $beforeRecordsAircraft = (new ShowAircraftService)->show();
    
        (new DeleteAircraftService)->delete();

        $afterRecordsAircraft = (new ShowAircraftService)->show();

        $this->assertLessThan($beforeRecordsAircraft->count(), $afterRecordsAircraft->count());
    }
}

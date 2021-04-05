<?php

use App\Models\Exceptions\InvalidAircraftSizeException;
use App\Services\StoreAircraftService;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\RecordsNotFoundException;
use PHPUnit\Framework\TestCase;

class StoreAircraftServiceTest extends TestCase
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

    public function test_store_aircraft_successfull()
    {
        $data = [
            'size' => 1,
            'aircraft_type_id' => 1
        ];

        $aircraft = (new StoreAircraftService)->store($data);

        $this->assertEquals(1, $aircraft->aircraft_type_id);
    }
    
    public function test_store_aircraft_invalid_size()
    {
        $data = [
            'size' => 100,
            'aircraft_type_id' => 1
        ];

        $this->expectException(InvalidAircraftSizeException::class);

        (new StoreAircraftService)->store($data);
    }

    public function test_store_aircraft_invalid_aircraft_type_id()
    {
        $data = [
            'size' => 1,
            'aircraft_type_id' => 100
        ];

        $this->expectException(RecordsNotFoundException::class);

        (new StoreAircraftService)->store($data);
    }
}

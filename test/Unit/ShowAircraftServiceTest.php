<?php

use App\Models\Exceptions\InvalidAircraftSizeException;
use App\Services\ShowAircraftService;
use App\Services\StoreAircraftService;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\RecordsNotFoundException;
use PHPUnit\Framework\TestCase;

class ShowAircraftServiceTest extends TestCase
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

        $aircrafts = (new ShowAircraftService)->show();

        $this->assertGreaterThanOrEqual(1, $aircrafts->count());
    }
}

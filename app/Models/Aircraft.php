<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aircraft extends Model
{
    use SoftDeletes;

    protected $table = 'aircrafts';
    protected $hidden = ['aircraft_type_id'];
    protected $fillable = ['size', 'aircraft_type_id'];
    protected $appends = ['size'];

    const SIZES = [
       1 => 'Small',
       2 => 'Large'
    ];

    public function getSizeAttribute()
    {
        return [
            1 => 'Small',
            2 => 'Large'
        ][$this->attributes['size']];
    }

    public function getPriorityColorAttribute()
    {
        return [
            'Emergency' => 'red',
            'VIP' => 'green',
            'Passenger,' => 'green',
        ][$this->attributes['description']] ?? 'cool-gray';
    }
    
    public function getPriorityAttribute()
    {
        return [
            'Emergency' => 'Hight',
            'VIP' => 'Normal',
            'Passenger,' => 'Normal',
        ][$this->attributes['description']] ?? 'Lowest';
    }
}

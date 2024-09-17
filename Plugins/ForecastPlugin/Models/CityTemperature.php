<?php

namespace App\Plugins\ForecastPlugin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityTemperature extends Model
{
    use HasFactory;

    protected $table = 'cities_temperature';

    protected $fillable = ['date','city_id','temperature','time_12_hour','time_24_hour','time_key'];
}

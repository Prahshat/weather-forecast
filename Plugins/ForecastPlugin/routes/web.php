<?php

use Illuminate\Support\Facades\Route;
use App\Plugins\ForecastPlugin\Controllers\WeatherController;
use App\Plugins\ForecastPlugin\Controllers\CronController;

Route::get('/weather', [WeatherController::class, 'city_weather'])->name('city_weather');
Route::get('/get_cities',[WeatherController::class,'get_cities'])->name('get_cities');

Route::get('/filter-weather-data',[WeatherController::class,'filter_weather_data'])->name('filter_weather_data');

//cron
Route::get('/capture-cities-weather',[CronController::class,'capture_cities_weather'])->name('fetch_open_meteo_data');
<?php

namespace App\Plugins\ForecastPlugin\Controllers;

use Illuminate\Http\Request;
use App\Plugins\ForecastPlugin\Models\City;
use App\Plugins\ForecastPlugin\Models\CityTemperature;
use Illuminate\Support\Carbon;

class WeatherController extends Controller
{
    //capture cities view
    public function get_cities(Request $request){
        $cities = City::all();
        return response()->json([
            'cities' => $cities
        ]);
    }
    //show cities weather
    public function city_weather(Request $request){
        $cities = City::all();

        $mytime = Carbon::now();

        $city_temp = CityTemperature::where(['city_id'=>$cities[0]->id,'date'=>substr($mytime->toDateTimeString(),0,10)]);
        $label = $city_temp->pluck('time_24_hour');
        $city_data = $city_temp->pluck('temperature');

        //get cities
        return view('forecastplugin::weathers.weather', ['cities' => $cities, 'label' => $label, 'city_data' => $city_data]);
    }
     public function filter_weather_data(Request $request){
        $city = $request->city;
        if($request->filter == 'week'){
            $type = $request->filter;
            //for capturing data day by day
            $data_container = [];
            for($i=0;$i<7;$i++){
                $total_temp = 0 ;
                $city_temp = CityTemperature::where(['city_id'=>$city,'date'=>substr(Carbon::now()->addDays($i)->toDateTimeString(),0,10)])->get();
                foreach($city_temp as $city_data){
                    $total_temp += $city_data->temperature;
                }
                $average_temp = $total_temp/24;
                array_push($data_container,(['temperatue'=>$average_temp,'date'=>substr(Carbon::now()->addDays($i)->toDateTimeString(),0,10)]));
            }
            //fetch temp wtih date
            $temperature = [];
            $date = [];
            foreach($data_container as $key=> $value){
                array_push($temperature,$value['temperatue']);
                $dayOfTheWeek = Carbon::parse($value['date'])->shortEnglishDayOfWeek;
                array_push($date,$value['date'].' ('.$dayOfTheWeek.')');
            }
            return response()->json([
                'temperature' => $temperature,
                'date' => $date
            ]);
        }else{
            //for day
            $city_temp = CityTemperature::where(['city_id'=>$city,'date'=>substr(Carbon::now()->toDateTimeString(),0,10)]);
            $label = $city_temp->pluck('time_24_hour');
            $city_data = $city_temp->pluck('temperature');
            return response()->json([
                'temperature' => $city_data,
                'date' => $label
            ]);
        }
    }
}

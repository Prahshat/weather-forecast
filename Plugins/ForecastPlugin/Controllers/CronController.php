<?php

namespace App\Plugins\ForecastPlugin\Controllers;

use Illuminate\Http\Request;
use App\Plugins\ForecastPlugin\Models\City;
use App\Plugins\ForecastPlugin\Models\CityTemperature;
use Illuminate\Support\Carbon;

class CronController extends Controller
{
    function __construct() {
        $this->client = new \GuzzleHttp\Client();
    }
    public function capture_cities_weather(Request $request)
    {

        try{
            //fetch all cities from db
            $all_cities = City::all();
            //update every city one by one
            foreach($all_cities as $city){
                //fetch the next seven day updated data
                for($i = 0;$i<7;$i++){
                    $date = Carbon::now()->addDays($i)->toDateString();
                    $url = 'https://api.open-meteo.com/v1/forecast?latitude='.$city->latitude.'&longitude='.$city->longitude.'&hourly=temperature_2m&start_date='.$date.'&end_date='.$date.'&timezone=Europe/Madrid';
                    $response = $this->client->get($url);

                    $results = $response->getBody();
                    $data = json_decode($results, true);

                    //capture the data into database
                    foreach($data['hourly']['time'] as $key => $day){
                        $the_day = substr($day,0,10);
                        $the_time = substr($day,11,15);
                        
                        // Create a Carbon instance from the 24-hour format time
                        $carbonTime = Carbon::createFromFormat('H:i', $the_time);

                        // Convert to 12-hour format
                        $time12Hour = $carbonTime->format('h:i A');

                        //check if available
                        $already_exist = cityTemperature::where(['date'=>$the_day,'city_id'=>$city->id,'time_key'=>$key])->first();
                        if(isset($already_exist)){
                            //if exist then update
                            $already_exist->update(['temperature'=>$data['hourly']['temperature_2m'][$key],'time_12_hour'=>$time12Hour]);
                        }
                        else{
                            //create process
                            $captured_data = ['date'=>$the_day,'city_id'=>$city->id,'temperature'=>$data['hourly']['temperature_2m'][$key],'time_12_hour'=>$time12Hour,'time_24_hour'=>$the_time,'time_key'=>$key];
                            cityTemperature::create($captured_data);
                        }
                    }
                    
                }
            }
        }
        catch(\Exception $err){
            dd($err->getMessage());
        }
        echo "Job done";
    }   
}

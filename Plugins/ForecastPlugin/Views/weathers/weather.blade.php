<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Application</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/forecastplugin/css/weather.css') }}">
</head>
<body>
    <h2 class="text-center">Weather Application</h2>
    <div class="dropDown">
    <div class="dropDownConatiner">
        <span>City : </span>
        <select name="city" id="city">
            @foreach($cities as $city)
                <option value="{{$city->id}}" selected>{{$city->name}}</option>
            @endforeach
        </select>
        <span>Duration: </span>
        <select name="day_week" id="day_week">
            <option value="day">Today</option>
            <option value="week">This Week</option>
        </select>
    </div>
    
    <div class="grap-section">
        <canvas id="lineChart"></canvas>
    </div>
    </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
         <script>
            $(document).ready(function() {
                var ctx = document.getElementById('lineChart').getContext('2d');
                myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($label),
                        datasets: [{
                            label: 'Temperature',
                            data: @json($city_data),
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: false,
                            pointRadius: (context) => {
                                var newDate = new Date();
                                return context.dataIndex === newDate.getHours() ? '7' : '4';
                            },
                            pointHoverRadius: (context) => {
                                var newDate = new Date();
                                return context.dataIndex === newDate.getHours() ? '7' : '4';
                            },
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    display: false,
                                },
                                beginAtZero: true
                            }
                        },
                    },
                });

                // for chaging day and week
                $("#day_week").change(function(){
                    var filter = $(this).val();
                    var city = $("#city").val();
                    $.ajax({
                        type: 'GET',
                        url: "{{route('filter_weather_data')}}",
                        data : {filter:filter,city:city},
                        success: function (resp) {
                            console.log(filter);
                            if (myChart) myChart.destroy();
                            var ctx = document.getElementById('lineChart').getContext('2d');
                            myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: resp.date,
                                    datasets: [{
                                        label: 'Temperature',
                                        data: resp.temperature,
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1,
                                        fill: false,
                                        pointRadius: (context) => {
                                            if(filter == 'week'){
                                                var newDate = new Date();
                                                const year = newDate.getFullYear();
                                                const month = String(newDate.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                                                const day = String(newDate.getDate()).padStart(2, '0');
                                                const today = `${year}-${month}-${day}`;
                                                return context.dataIndex === 0 ? '7' : '4';
                                            }
                                            else{
                                                var newDate = new Date();
                                                return context.dataIndex === newDate.getHours() ? '7' : '4';
                                            }
                                        },
                                        pointHoverRadius: (context) => {
                                            if(filter == 'week'){
                                                var newDate = new Date();
                                                const year = newDate.getFullYear();
                                                const month = String(newDate.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                                                const day = String(newDate.getDate()).padStart(2, '0');
                                                const today = `${year}-${month}-${day}`;
                                                return context.dataIndex === 0 ? '7' : '4';
                                            }
                                            else{
                                                var newDate = new Date();
                                                return context.dataIndex === newDate.getHours() ? '7' : '4';
                                            }
                                        },
                                    }]
                                },
                                options: {
                                    scales: {
                                        x: {
                                            grid: {
                                                display: false
                                            }
                                        },
                                        y: {
                                            grid: {
                                                display: false,
                                            },
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        },
                        error: function() { 
                            console.log(resp);
                        }
                    });
                });
            });
         </script>
</body>
</html>
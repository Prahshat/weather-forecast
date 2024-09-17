# ForecastPlugin for Laravel

The **ForecastPlugin** is a Laravel plugin that captures weather data and displays forecasts for the Palma city.

## Installation Steps

Follow these steps to install and set up the ForecastPlugin in your Laravel project:

### 1. Download the source code from git**

- You can download it manually by clicking download zip.
- You can take git clone too.

   a.) Run command 'git clone https://github.com/Prahshat/weather-forcast.git'
      ** use these credentails for clone:- **

        user :- Prahshat
        Password :- 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

   b.) New Folder named weather-forcast will be clone to the directory. you will find the zip of the plugin in that folder.


### 2. Extract the Zip File
- Extract the Plugins.zip file into the `app` directory of your Laravel project.

### 3. Register the Service Provider
- Open the `ROOT_DIRECTORY/config/app.php` file.
- Add the following line to the `providers` array:

    ```php
    'providers' => [
        // Other Service Providers
        App\Plugins\ForecastPlugin\ForecastPluginServiceProvider::class,
    ],
    ```

### 4. Run Migrations
- In the project root directory, run the following command to create the necessary database tables:

    ```bash
    php artisan migrate
    ```

### 5. Run Database Seeders
- Populate the database with initial data by running:

    ```bash
    php artisan db:seed
    ```

### 6. Capture Cities Weather
- Hit the following URL in your browser:

    ```
    http://YOUR_PROJECT_BASEURL/capture-cities-weather
    ```

- Wait for the process to complete. If you encounter a "permission denied" error, please ensure you have set the correct file permissions according to Laravel's standards.

### 7. Publish Public Assets
- Run the following command to publish public assets:

    ```bash
    php artisan vendor:publish --tag=public
    ```

### 8. View the Weather Forecast
- Finally, visit the following URL to see the weather forecast for Palma city:

    ```
    http://YOUR_PROJECT_BASEURL/Weather
    ```


<?php

namespace App\Plugins\ForecastPlugin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ForecastPluginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register the plugin's routes
        $this->loadRoutesFrom(app_path('Plugins/ForecastPlugin/routes/web.php'));

        // Register the plugin's views
        $this->loadViewsFrom(app_path('Plugins/ForecastPlugin/Views'), 'forecastplugin');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
         // Load routes and views if applicable
        $this->loadRoutesFrom(app_path('Plugins/ForecastPlugin/routes/web.php'));
        $this->loadViewsFrom(app_path('Plugins/ForecastPlugin/Views'), 'forecastplugin');
        
        $this->loadMigrationsFrom(app_path('Plugins/ForecastPlugin/database/migrations'));
        // Publish assets from the plugin to the public directory
        $this->publishes([
            app_path('Plugins/ForecastPlugin/public') => public_path('plugins/forecastplugin'),
        ], 'public');
        $this->runSeeders();
    }
    protected function runSeeders()
    {
        $seederClass = 'App\Plugins\ForecastPlugin\database\seeders\CitiesSeeder';
        $seederName = 'cities_seeder';
        if (!\Schema::hasTable('seeder_flags')) {
            // If the table does not exist, skip everything
            return;
        }
        // Check if seeder has already run
        $hasRun = \DB::table('seeder_flags')
                     ->where('name', $seederName)
                     ->exists();

        if (!$hasRun) {
            // Run the seeder
            Artisan::call('db:seed', [
                '--class' => $seederClass,
            ]);

            // Mark the seeder as run
            \DB::table('seeder_flags')->insert([
                'name' => $seederName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

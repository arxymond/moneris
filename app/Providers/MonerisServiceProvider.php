<?php

namespace MonerisAssignment\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;
use MonerisAssignment\Services\MonerisPaymentService;

/**
 * Class MonerisServiceProvider
 * @package MonerisAssignment\Providers
 */
class MonerisServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //Config
        $this->mergeConfigFrom(__DIR__.'/../../config/moneris.php', 'moneris');

        $this->app->bind('moneris', MonerisPaymentService::class);

        //Facades
        $this->app->alias(MonerisPaymentService::class, 'moneris');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Because of using custom namespaces for the project and especially for Models,
        // Laravel have the issue resolving Model Factory classes.
        // In real life project ether we have all Models with that custom namespaces,
        // or we have to have the list of Models that are used with custom namespaces and use that in this block
        // For this test project I am going to hardcode all my Models with uncommon namespaces and use that list here,
        // to tell Laravel where my Factory classes are

        Factory::guessFactoryNamesUsing(function (string $moduleName) {
            $customModels = ['Customer', 'PaymentMethod', 'Transaction'];
            if(in_array(class_basename($moduleName), $customModels))
                return 'MonerisAssignment\\Database\\Factories\\'.class_basename($moduleName).'Factory';
            else
                return 'Database\\Factories\\'.class_basename($moduleName).'Factory';
        });



        $this->app->bind('moneris', MonerisPaymentService::class);

        // publishing moneris.php config file
        $this->publishes([
            __DIR__.'/../config/monris.php' => config_path('moneris.php'),
        ]);

        // migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}

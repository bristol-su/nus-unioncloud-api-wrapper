<?php
/**
 * Service provider for UnionCloud
 */

namespace Twigger\UnionCloud\API;

use Illuminate\Support\ServiceProvider;


/**
 * Allow Laravel to use UnionCloud
 * Class UnionCloudServiceProvider
 *
 * @package Twigger\UnionCloud\API
 */
class UnionCloudServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../laravel/resources/config/unioncloud.php' => config_path('unioncloud.php'),
        ]);

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('Unioncloud', function($app){
            $unionCloud = new UnionCloud([
                'email' => $app->config['unioncloud']['v0auth']['email'],
                'password' => $app->config['unioncloud']['v0auth']['password'],
                'appID' => $app->config['unioncloud']['v0auth']['appID'],
                'appPassword' => $app->config['unioncloud']['v0auth']['appPassword'],
            ]);
            $unionCloud->setBaseURL($app->config['unioncloud']['baseURL']);

        });
    }

}
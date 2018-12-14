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
 * @package Twigger\UnionCloud\API\Laravel
 */
class UnionCloudServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../publish/config/unioncloud.php' => config_path('unioncloud.php'),
        ], 'configtest');

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('Twigger\UnionCloud\API\UnionCloud', function($app){
            $unionCloud = new UnionCloud([
                'email' => config('unioncloud.v0auth.email', 'email'),
                'password' => config('unioncloud.v0auth.password', 'password'),
                'appID' => config('unioncloud.v0auth.appID', 'appID'),
                'appPassword' => config('unioncloud.v0auth.appPassword', 'appPassword'),
            ]);
            $unionCloud->setBaseURL(config('unioncloud.baseURL', 'union.unioncloud.org'));
            return $unionCloud;
        });
    }

}
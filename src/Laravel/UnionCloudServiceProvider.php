<?php
/**
 * Service provider for UnionCloud
 */

namespace Twigger\UnionCloud\API\Laravel;

use Illuminate\Support\ServiceProvider;
use Twigger\UnionCloud\API\UnionCloud;


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
            __DIR__ . '/config/unioncloud.php' => config_path('unioncloud.php'),
        ], 'config');

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
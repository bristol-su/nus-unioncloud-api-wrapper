<?php
/**
 * Service provider for UnionCloud
 */

namespace Twigger\UnionCloud\API;

use Illuminate\Support\ServiceProvider;
use Twigger\UnionCloud\API\Auth\awsAuthenticator;


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
            __DIR__ . '/../publish/config/unioncloud.php' => config_path('unioncloud.php'),
        ], 'configtest');

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('Twigger\UnionCloud\API\UnionCloud', function ($app) {
            if($app['config']->get('unioncloud.authenticator', 'v0') === 'v0') {
                $unionCloud = new UnionCloud([
                    'email' => config('unioncloud.v0auth.email', 'email'),
                    'password' => config('unioncloud.v0auth.password', 'password'),
                    'appID' => config('unioncloud.v0auth.appID', 'appID'),
                    'appPassword' => config('unioncloud.v0auth.appPassword', 'appPassword'),
                ]);
            } else if($app['config']->get('unioncloud.authenticator', 'v0') === 'v1') {
                $unionCloud = new UnionCloud([
                    'accessKey' => config('unioncloud.v1auth.accessKey'),
                    'secretKey' => config('unioncloud.v1auth.secretKey'),
                    'apiKey' => config('unioncloud.v1auth.apiKey')
                ], new awsAuthenticator());
            }
            $unionCloud->setBaseURL(config('unioncloud.baseURL'));
            return $unionCloud;
        });
    }

}
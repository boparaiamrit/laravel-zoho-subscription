<?php

namespace Boparaiamrit\ZohoSubscription;

use Boparaiamrit\ZohoSubscription\API\Addon;
use Boparaiamrit\ZohoSubscription\API\Customer;
use Boparaiamrit\ZohoSubscription\API\HostedPage;
use Boparaiamrit\ZohoSubscription\API\Invoice;
use Boparaiamrit\ZohoSubscription\API\Plan;
use Boparaiamrit\ZohoSubscription\API\Subscription;
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;

class ZohoSubscriptionServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(__DIR__ . '/../config/zoho_subscription.php', 'zoho_subscription');

        $this->publishes([
                             __DIR__ . '/../config/zoho_subscription.php' => config_path('zoho_subscription.php'),
                         ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /** @var Repository $config */
        $config         = $this->app->make('config');
        $token          = $config->get('zoho_subscription.token');
        $organisationID = $config->get('zoho_subscription.organisation_id');

        $this->app->singleton('zoho_subscription', function ($app) use ($token, $organisationID) {
            return new Subscription($token, $organisationID, $app['config']);
        });

        $this->app->singleton('zoho_subscription.subscription', function ($app) use ($token, $organisationID) {
            return new Subscription($token, $organisationID, $app['config']);
        });

        $this->app->singleton('zoho_subscription.customer', function ($app) use ($token, $organisationID) {
            return new Customer($token, $organisationID, $app['config']);
        });

        $this->app->singleton('zoho_subscription.invoice', function ($app) use ($token, $organisationID) {
            return new Invoice($token, $organisationID, $app['config']);
        });

        $this->app->singleton('zoho_subscription.plan', function ($app) use ($token, $organisationID) {
            return new Plan($token, $organisationID, $app['config']);
        });

        $this->app->singleton('zoho_subscription.addon', function ($app) use ($token, $organisationID) {
            return new Addon($token, $organisationID, $app['config']);
        });

        $this->app->singleton('zoho_subscription.hosted_page', function ($app) use ($token, $organisationID) {
            return new HostedPage($token, $organisationID, $app['config']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'zoho_subscription',
            'zoho_subscription.subscription',
            'zoho_subscription.customer',
            'zoho_subscription.plan',
            'zoho_subscription.invoice',
            'zoho_subscription.addon',
            'zoho_subscription.hosted-page'
        ];
    }
}
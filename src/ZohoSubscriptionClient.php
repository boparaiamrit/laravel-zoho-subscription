<?php

namespace Boparaiamrit\ZohoSubscription;

use Boparaiamrit\ZohoSubscription\API\Addon;
use Boparaiamrit\ZohoSubscription\API\Customer;
use Boparaiamrit\ZohoSubscription\API\HostedPage;
use Boparaiamrit\ZohoSubscription\API\Invoice;
use Boparaiamrit\ZohoSubscription\API\Plan;
use Boparaiamrit\ZohoSubscription\API\Subscription;
use GuzzleHttp\Client;

class ZohoSubscriptionClient
{
    protected $passThrough = [
        'subscription',
        'plan',
        'invoice',
        'customer',
        'addon',
        'hostedPage'
    ];

    public function __construct($token, $organizationId, $ttl = 7200)
    {
        $this->token          = $token;
        $this->organizationId = $organizationId;
        $this->Cache          = app('cache.store');
        $this->ttl            = $ttl;
        $this->Client         = new Client(['base_uri' => 'https://subscriptions.zoho.com/api/v1/', 'timeout' => 2.0]);
    }

    function __call($name, $arguments)
    {
        if (array_has($this->passThrough, 'name')) {
            switch ($name) {
                case 'subscription':
                    new Subscription(array_get($arguments, 0, $this->token), array_get($arguments, 1, $this->organizationId), $this->Cache);
                    break;
                case 'plan':
                    new Plan(array_get($arguments, 0, $this->token), array_get($arguments, 1, $this->organizationId), $this->Cache);
                    break;
                case 'invoice':
                    new Invoice(array_get($arguments, 0, $this->token), array_get($arguments, 1, $this->organizationId), $this->Cache);
                    break;
                case 'customer':
                    new Customer(array_get($arguments, 0, $this->token), array_get($arguments, 1, $this->organizationId), $this->Cache);
                    break;
                case 'addon':
                    new Addon(array_get($arguments, 0, $this->token), array_get($arguments, 1, $this->organizationId), $this->Cache);
                    break;
                case 'hosted_page':
                    new HostedPage(array_get($arguments, 0, $this->token), array_get($arguments, 1, $this->organizationId), $this->Cache);
                    break;
            }
        }

        throw new \Exception($name . ' action no found');
    }
}
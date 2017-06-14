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

    public function subscription()
    {
        return new Subscription($this->token, $this->organizationId, $this->Cache);
    }

    public function plan()
    {
        return new Plan($this->token, $this->organizationId, $this->Cache);
    }

    public function invoice()
    {
        return new Invoice($this->token, $this->organizationId, $this->Cache);
    }

    public function customer()
    {
        return new Customer($this->token, $this->organizationId, $this->Cache);
    }

    public function addon()
    {
        return new Addon($this->token, $this->organizationId, $this->Cache);
    }

    public function hostedPage()
    {
        return new HostedPage($this->token, $this->organizationId, $this->Cache);
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendSubscriptionExpiryNotification;

class TestSubscriptionExpiryNotification extends Command
{
    protected $signature = 'test:subscription-expiry-notification';
    protected $description = 'Test the subscription expiry notification job';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Executar o job manualmente
        SendSubscriptionExpiryNotification::dispatch();

        $this->info('Subscription expiry notification job executed successfully.');
    }
}


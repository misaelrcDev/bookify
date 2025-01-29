<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Cashier\Subscription; // Import correto para a classe Subscription do Laravel Cashier
use Carbon\Carbon;

class UpdateSubscriptionEndsAt extends Command
{
    protected $signature = 'subscriptions:update-ends-at';
    protected $description = 'Atualiza o campo ends_at para assinaturas existentes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $subscriptions = Subscription::whereNull('ends_at')->get();

        foreach ($subscriptions as $subscription) {
            $subscription->ends_at = Carbon::parse($subscription->created_at)->addMonth();
            $subscription->save();

            $this->info('Assinatura atualizada: ' . $subscription->id);
        }

        $this->info('Atualização concluída.');
    }
}


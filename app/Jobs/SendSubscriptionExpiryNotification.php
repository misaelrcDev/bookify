<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionExpiry;
use Illuminate\Support\Facades\Log;

class SendSubscriptionExpiryNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $users = User::whereHas('subscriptions', function($query) {
            $query->where('stripe_status', 'active');
        })->get();

        foreach ($users as $user) {
            $subscription = $user->subscription('default');
            $expiryDate = $subscription->ends_at ? Carbon::parse($subscription->ends_at) : Carbon::parse($subscription->created_at)->addMonth();
            $currentDate = Carbon::now();
            $daysUntilExpiry = $currentDate->diffInDays($expiryDate, false);

            // Log para verificar as datas de vencimento
            Log::info('Verificando assinatura do usuário', [
                'user_id' => $user->id,
                'expiry_date' => $expiryDate->toDateString(),
                'current_date' => $currentDate->toDateString(),
                'days_until_expiry' => $daysUntilExpiry
            ]);

            if ($daysUntilExpiry <= 7 && $daysUntilExpiry >= 0) { // Notificar 7 dias antes do vencimento e não após a data
                Mail::to($user->email)->send(new SubscriptionExpiry($user, $subscription));
            }
        }
    }
}


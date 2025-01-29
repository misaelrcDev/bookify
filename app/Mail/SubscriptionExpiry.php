<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Laravel\Cashier\Subscription;

class SubscriptionExpiry extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subscription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Subscription $subscription)
    {
        $this->user = $user;
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notificação de Vencimento de Assinatura')
                    ->view('emails.subscription_expiry');
    }
}

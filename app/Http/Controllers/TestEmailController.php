<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionExpiry;
use App\Models\User;
use Laravel\Cashier\Subscription; // Certifique-se de importar o pacote correto

class TestEmailController extends Controller
{
    public function sendTestEmail()
    {
        $user = User::first(); // Substitua por um usuário válido do seu banco de dados
        $subscription = $user->subscription('default'); // Assumindo que o usuário tem uma assinatura

        Mail::to($user->email)->send(new SubscriptionExpiry($user, $subscription));

        return 'E-mail de teste enviado com sucesso!';
    }
}



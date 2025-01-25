<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Subscription extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Gerenciar Assinatura';
    protected static string $view = 'filament.pages.subscription';
    protected static ?string $title = 'Gerenciar Assinatura';

    // Validações
    public array $formData = [
        'plan' => '',
        'paymentMethod' => '',
    ];

    // Processar a assinatura (POST)
    public function updateSubscription()
    {
        $data = request()->validate([
            'plan' => 'required|string',
            'paymentMethod' => 'required|string',
        ]);

        $user = Auth::user();

        if (!$user->stripe_id) {
            $user->createOrGetStripeCustomer();
        }

        // Criar ou atualizar a assinatura
        $user->newSubscription('default', $data['plan'])->create($data['paymentMethod']);

        session()->flash('success', 'Assinatura atualizada com sucesso!');
        return redirect()->route('filament.pages.subscription');
    }
}


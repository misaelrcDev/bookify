<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Subscription extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Gerenciar Assinatura';

    protected static string $view = 'filament.pages.subscription';

    public function updateSubscription(Request $request)
    {
        $company = Auth::user()->company;

        $request->validate([
            'plan' => 'required|string',
        ]);

        $company->newSubscription('default', $request->plan)->create($request->paymentMethod);

        session()->flash('success', 'Assinatura atualizada com sucesso!');
        return redirect()->route('filament.pages.subscription');
    }
}


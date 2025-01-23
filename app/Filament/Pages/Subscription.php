<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Subscription extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Gerenciar Assinatura';
    // protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.subscription';
    protected static ?string $title = null;

    public static function getModelLabel(): string
    {
        return __('Subscription');
    }

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


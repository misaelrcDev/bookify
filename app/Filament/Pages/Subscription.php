<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class Subscription extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Gerenciar Assinatura';
    // protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.pages.subscription';
    protected static ?string $title = '';

    public function updateSubscription(Request $request)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();
        $company = $user->company;

        // Verificação adicional e criação de empresa, se não existir
        if (!$company) {
            $company = Company::create(['user_id' => $user->id, 'name' => 'Nome da Empresa']); // Modifique conforme necessário
            $user->company()->associate($company);
            $user->save();
        }

        // Validação dos campos do request
        $request->validate([
            'plan' => 'required|string',
            'paymentMethod' => 'required|string',
        ]);

        // Criar nova assinatura
        $company->newSubscription('default', $request->plan)->create($request->paymentMethod);

        // Mensagem de sucesso
        session()->flash('success', 'Assinatura atualizada com sucesso!');
        return redirect()->route('filament.pages.subscription');
    }

}

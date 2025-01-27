<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ServiceResource;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Verifica duplicação
        $existingService = Service::where('name', $data['name'])
            ->where('user_id', Auth::id())
            ->first();

        if ($existingService) {
            // Exibe notificação amigável
            Notification::make()
                ->title('Serviço Duplicado')
                ->body('Já existe um serviço com esse nome.')
                ->danger()
                ->send();

            // Retorna o usuário ao formulário sem criar o registro
            $this->halt(); // Interrompe o processo de criação
        }

        return $data;
    }
}

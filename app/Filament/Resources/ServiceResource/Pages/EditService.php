<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Verifica duplicação ao editar
        if (Service::where('name', $data['name'])
            ->where('user_id', Auth::id())
            ->where('id', '!=', $this->record->id)
            ->exists()) {
            // throw new \Exception('Já existe um serviço com esse nome.');
        }

        return $data;
    }
}

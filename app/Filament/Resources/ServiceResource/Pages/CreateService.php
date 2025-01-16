<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $existingService = Service::withTrashed()
        ->where('name', $data['name'])
        ->where('user_id', Auth::id())
        ->first();

    if ($existingService) {
        // if ($existingService->trashed()) {
        //     // Restaura o serviço deletado
        //     $existingService->restore();
        //     throw new \Exception('O serviço foi restaurado e está disponível novamente.');
        // }

        throw new \Exception('Já existe um serviço com esse nome.');
    }

    return $data;
    }
}

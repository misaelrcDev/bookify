<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ReservationsCount extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Reservas', Booking::where('user_id', Auth::id())->count()),
        ];
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Filament\Support\RawJs;

class ReservationsChart extends ChartWidget
{
    protected static ?string $heading = 'Reservas por Mês';

    protected function getData(): array
    {
        $userId = Auth::id();

        $query = Booking::where('user_id', $userId);

        $data = Trend::query($query)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();
        
        return [
            'datasets' => [
                    [
                        'label' => 'Reservas por mês',
                        'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    ],
                ],
                'labels' => $data->map(fn (TrendValue $value) => $value->date),
            ];
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
            {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return Number.isInteger(value) ? value : null;
                            },
                            stepSize: 1 // Define a escala do eixo Y para passos inteiros
                        },
                    },
                },
            }
        JS);
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

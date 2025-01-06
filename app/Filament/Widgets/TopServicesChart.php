<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Service; // Supondo que você tenha um modelo de Service
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Filament\Support\RawJs;

class TopServicesChart extends ChartWidget
{
    protected static ?string $heading = 'Serviços Mais Reservados';

    protected function getData(): array
    {
        $userId = Auth::id();

        $services = Service::all(); // Supondo que você tenha um modelo de Service
        $serviceReservations = [];
        foreach ($services as $service) {
            $serviceReservations[$service->name] = Booking::where('user_id', $userId)
                ->where('service_id', $service->id)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Serviços mais reservados',
                    'data' => array_values($serviceReservations),
                ],
            ],
            'labels' => array_keys($serviceReservations),
        ];
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
            {
                plugins: {
                    legend: {
                        display: false // Desabilita a exibição da legenda
                    }
                },
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

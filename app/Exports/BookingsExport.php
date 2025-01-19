<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, WithHeadings
{
    protected $bookings;

    public function __construct(?Collection $bookings = null)
    {
        $this->bookings = $bookings ?? collect();
    }

    public function collection()
    {
        return $this->bookings->isNotEmpty() ? $this->bookings : Booking::with('service')->where('user_id', Auth::user()->id)->get()->map(function ($booking) {
            return [
                'client_name' => $booking->client_name,
                'service' => $booking->service->name,
                'start_time' => $booking->start_time,
                'end_time' => $booking->end_time,
            ];
        });
    }

    public function headings(): array
    {
        return ['Cliente', 'Serviço', 'Data e Hora de Início', 'Data e Hora de Término'];
    }
}

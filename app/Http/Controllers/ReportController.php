<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function exportPdf(Request $request)
    {
        // Obtém os IDs dos bookings selecionados
        $selectedIds = $request->input('selected', []);

        // Filtra os bookings pelo usuário logado e pelos IDs selecionados
        $bookings = Booking::with('service')
            ->where('user_id', Auth::user()->id)
            ->whereIn('id', $selectedIds)
            ->get()
            ->map(function($booking) {
                return [
                    'client_name' => $booking->client_name,
                    'service' => $booking->service->name,
                    'start_time' => $booking->start_time,
                    'end_time' => $booking->end_time,
                ];
            });

        // Gera o PDF
        $pdf = Pdf::loadView('reports.bookings', compact('bookings'));

        return $pdf->download('bookings.pdf');
    }
}


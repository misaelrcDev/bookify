<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Mail\ReportEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Barryvdh\DomPDF\Facade\Pdf;

class SendReportEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $selectedIds;

    public function __construct($email, $selectedIds)
    {
        $this->email = $email;
        $this->selectedIds = $selectedIds;
    }

    public function handle()
    {
        $bookings = Booking::with('service')
            ->where('user_id', Auth::user()->id)
            ->whereIn('id', $this->selectedIds)
            ->get()
            ->map(function($booking) {
                return [
                    'client_name' => $booking->client_name,
                    'service' => $booking->service->name,
                    'start_time' => $booking->start_time,
                    'end_time' => $booking->end_time,
                ];
            });

        $pdf = Pdf::loadView('reports.bookings', compact('bookings'));

        Mail::to($this->email)->send(new ReportEmail($pdf->output()));
    }
}



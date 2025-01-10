<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ReportEmail;
use Illuminate\Support\Facades\Auth;

class SendScheduledReports extends Command
{
    protected $signature = 'reports:send';
    protected $description = 'Envia relatórios periódicos para os administradores';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $admins = ['test@test.com', 'test2@test.com']; // Adicione os e-mails dos administradores

        foreach ($admins as $email) {
            $this->sendReport($email);
        }

        $this->info('Relatórios enviados com sucesso!');
    }

    protected function sendReport($recipient)
    {
        $bookings = Booking::with('service')
            ->where('user_id', Auth::user()->id)
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

        Mail::to($recipient)->send(new ReportEmail($pdf->output()));
    }
}


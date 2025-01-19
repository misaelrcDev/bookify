<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Jobs\SendReservationReminderEmail;
use Carbon\Carbon;

class SendReservationReminders extends Command
{
    protected $signature = 'reservations:send-reminders';
    protected $description = 'Envia lembretes de reservas próximas para os clientes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tomorrow = Carbon::now()->addDay();

        // Obtenha reservas cujo horário de início é amanhã
        $bookings = Booking::whereDate('start_time', $tomorrow->toDateString())->get();

        foreach ($bookings as $booking) {
            SendReservationReminderEmail::dispatch($booking);
        }

        $this->info('Lembretes de reservas enviados com sucesso!');
    }
}


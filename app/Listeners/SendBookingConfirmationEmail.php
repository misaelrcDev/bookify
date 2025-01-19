<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\BookingConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmationEmail implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        // Acesse a reserva a partir do evento
        $booking = $event->booking;

        // Envia o e-mail de confirmação para o cliente
        Mail::to($booking->client_email)->send(new BookingConfirmation($booking));
    }
}

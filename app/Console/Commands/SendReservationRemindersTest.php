<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\SendReservationReminders;

class SendReservationRemindersTest extends Command
{
    protected $signature = 'test:send-reminders';
    
    protected $description = 'Força a execução do envio de lembretes de reservas próximas para teste';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->call(SendReservationReminders::class);
        $this->info('Lembretes de reservas enviados para teste!');
    }
}


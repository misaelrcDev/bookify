<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdfContent;

    public function __construct($pdfContent)
    {
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->view('emails.report')
            ->subject('Relatório de Reservas')
            ->attachData($this->pdfContent, 'report.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}

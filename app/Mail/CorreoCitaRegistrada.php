<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoCitaRegistrada extends Mailable
{
    public $nuevaCita;
    public $datos;
    public $requisitos;

    public function __construct($nuevaCita, $datos, $requisitos)
    {
        $this->nuevaCita = $nuevaCita;
        $this->datos = $datos;
        $this->requisitos = $requisitos;
    }

    public function build()
    {
        return $this->view('emails.prueba')
                    ->with([
                        'datos' => $this->datos,
                        'requisitos' => $this->requisitos,
                        // Aquí puedes agregar más datos si los necesitas
                    ]);
    }
}


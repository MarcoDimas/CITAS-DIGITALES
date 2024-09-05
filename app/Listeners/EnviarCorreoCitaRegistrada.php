<?php

namespace App\Listeners;

use App\Events\CitaRegistrada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EnviarCorreoCitaRegistrada
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CitaRegistrada $event)
    {
        $cita = $event->cita;

        // Lógica para enviar el correo electrónico
        Mail::send('emails.citaRegistrada', ['cita' => $cita], function ($message) use ($cita) {
            $message->to($cita->email)
                    ->subject('Registro de cita exitoso');
        });
    }
}

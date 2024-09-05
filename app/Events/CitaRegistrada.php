<?php

namespace App\Events;

use App\Models\Cita;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CitaRegistrada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cita;

    public function __construct(Cita $cita)
    {
        $this->cita = $cita;
    }
}

<?php

namespace App\Models\Bookings;

use Fmk\Facades\Model;

class Documento extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'documentos';
	
	public function reserva() {
        return $this->belongsTo(Reserva::class, 'reservas_id');
    }
}

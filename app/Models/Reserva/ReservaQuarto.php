<?php

namespace App\Models;

use Fmk\Facades\Model;

class ReservaQuarto extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'reserva_quartos';
	
	public function reserva() {
        return $this->belongsTo(Reserva::class, 'reservas_id');
    }

    public function reservaAdicionais() {
        return $this->hasMany(ReservaQuartoAdicional::class, 'reservas_quartos_id');
    }
}

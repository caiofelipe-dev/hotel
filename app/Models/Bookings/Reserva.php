<?php

namespace App\Models\Bookings;

use Fmk\Facades\Model;

class Reserva extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'reservas';
	
	public function hospede() {
		return $this->belongsTo(Hospede::class, 'hospedes_id');
	}
	public function documentos() {
		return $this->hasMany(Documento::class, 'reservas_id');
	}
	public function reservaQuartos() {
		return $this->hasMany(ReservaQuarto::class, 'reservas_id');
	}
}

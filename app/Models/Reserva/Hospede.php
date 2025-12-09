<?php

namespace App\Models;

use Fmk\Facades\Model;

class Hospede extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'hospedes';
	
	public function reserva() {
        return $this->hasOne(Reserva::class, 'hospedes_id');
    }
}

<?php

namespace App\Models;

use Fmk\Facades\Model;

class ReservaQuartoAdicional extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'reserva_quarto_adicionais';
    
    public function quartoAdicional() {
        return $this->belongsTo(QuartoAdicional::class, 'quartos_adicionais_id');
    }
    public function reservaQuarto() {
        return $this->belongsTo(ReservaQuarto::class, 'reserva_quartos_id');
    }
}

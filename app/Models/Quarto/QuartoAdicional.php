<?php

namespace App\Models;

use Fmk\Facades\Model;

class QuartoAdicional extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'quartos_adicionais';
    
    public function quarto() {
        return $this->belongsTo(Quarto::class, 'quartos_id');
    }
    public function adicional() {
        return $this->belongsTo(AdicionalTipo::class, 'adicionais_tipos_id');
    }
}

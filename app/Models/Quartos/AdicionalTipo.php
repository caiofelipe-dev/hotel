<?php

namespace App\Models\Quartos;

use Fmk\Facades\Model;

class AdicionalTipo extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'adicionais_tipos';
	
	public function quartoAdicionais() {
		return $this->hasMany(QuartoAdicional::class, 'adicionais_tipos_id');
	}
}

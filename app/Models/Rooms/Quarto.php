<?php

namespace App\Models\Rooms;

use Fmk\Facades\Model;

class Quarto extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'quartos';
	
	public function adicionais() {
		return $this->hasMany(QuartoAdicional::class, 'quartos_id');
	}

	public function listAdicionais() {
		$associativos = $this->adicionais()->exec();
		
	}
}

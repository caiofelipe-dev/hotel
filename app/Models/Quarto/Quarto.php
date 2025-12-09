<?php

namespace App\Models;

use Fmk\Facades\Model;

class Quarto extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'quartos';
	
	public function adicionais() {
		return $this->hasMany(\App\Models\QuartoAdicional::class, 'quartos_id');
	}

	public function listAdicionais() {
		$associativos = $this->adicionais()->exec();
		
	}
}

<?php

namespace App\Models\Quartos;

use Fmk\Facades\Model;

class Quarto extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'quartos';
	
	public function quartoAdicionais() {
		return $this->hasMany(\App\Models\Quartos\QuartoAdicional::class, 'quartos_id');
	}
	public function adicionais() {
		$adicionais = [];
		foreach($this->quartoAdicionais as $q) {
			$adicionais[] = $q->adicional;
		}
		return $adicionais;
	}
}

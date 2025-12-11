<?php

namespace App\Models\Employees;

use Fmk\Facades\Model;

class Cargo extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'cargos';
	
	public function funcionarios() {
		return $this->hasMany(Funcionario::class, 'cargos_id');
	}
}

<?php

namespace App\Models\Employees;

use Fmk\Facades\Model;

class ServicoTipo extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'servico_tipos';
	
	public function funcionarioServicos() {
		return $this->hasMany(FuncionarioServico::class, 'servico_tipos_id');
	}
}

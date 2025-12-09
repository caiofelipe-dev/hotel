<?php

namespace App\Models;

use Fmk\Facades\Model;

class ServicoTipo extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'servico_tipos';
	
	public function funcionarioServicos() {
		return $this->hasMany(\App\Models\FuncionarioServico::class, 'servico_tipos_id');
	}
}

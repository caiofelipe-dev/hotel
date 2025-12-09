<?php

namespace App\Models;

use Fmk\Facades\Model;

class FuncionarioServico extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'funcionario_servicos';
	
	public function funcionario() {
		return $this->belongsTo(\App\Models\Funcionario::class, 'funcionarios_id');
	}
	public function servicoTipo() {
		return $this->belongsTo(\App\Models\QuartoAdicional::class, 'servico_tipos_id');
	}
}

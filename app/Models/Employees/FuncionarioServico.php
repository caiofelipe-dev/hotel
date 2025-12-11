<?php

namespace App\Models\Employees;

use Fmk\Facades\Model;

class FuncionarioServico extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'funcionario_servicos';
	
	public function funcionario() {
		return $this->belongsTo(Funcionario::class, 'funcionarios_id');
	}
	public function servicoTipo() {
		return $this->belongsTo(ServicoTipo::class, 'servico_tipos_id');
	}
}

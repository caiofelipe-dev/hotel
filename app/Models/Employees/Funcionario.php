<?php

namespace App\Models\Employees;

use Fmk\Facades\Model;

class Funcionario extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'funcionarios';
	
	public function funcionarioServicos() {
		return $this->hasMany(FuncionarioServico::class, 'funcionarios_id');
	}
    public function cargo() {
        return $this->belongsTo(Cargo::class, 'cargos_id');
    }
}

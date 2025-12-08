<?php

namespace App\Models;

use Fmk\Facades\Model;

/**
 * Modelo Quarto — representa a tabela `quartos` definida em `storage/sql/blank.sql`.
 * Mantemos o padrão do framework: o nome da tabela é inferido a partir do nome da classe
 * (lowercase + 's'), mas definimos explicitamente por clareza.
 */
class QuartosAdicionais extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'quartos_adicionais';
    
    public function quartos() {
        return $this->belongsTo(\App\Models\Quartos::class, 'quartos_id');
    }
}

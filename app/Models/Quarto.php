<?php

namespace App\Models;

use Fmk\Facades\Model;

/**
 * Modelo Quarto — representa a tabela `quartos` definida em `storage/sql/blank.sql`.
 * Mantemos o padrão do framework: o nome da tabela é inferido a partir do nome da classe
 * (lowercase + 's'), mas definimos explicitamente por clareza.
 */
class Quarto extends Model
{
	// Nome da tabela no banco de dados
	protected static $table = 'quartos';

	// Chave primária
	protected static $pk = 'id';

}

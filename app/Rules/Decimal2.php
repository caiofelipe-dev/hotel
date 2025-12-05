<?php

namespace App\Rules;

use Fmk\Interfaces\Rule;

class Decimal2 implements Rule
{
    public function __construct()
    {
    }

    public function passes($value): bool
    {
        if ($value === null || $value === '') return false;
        // Accept numbers with decimal separator . or ,
        $v = str_replace(',', '.', (string)$value);
        return is_numeric($v) && preg_match('/^\d+(\.\d{1,2})?$/', $v);
    }

    public function error($atribute): string
    {
        return "O campo $atribute deve ser um valor numérico com até duas casas decimais.";
    }
}

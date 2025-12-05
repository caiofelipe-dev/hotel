<?php

namespace App\Rules;

use Fmk\Interfaces\Rule;

class IntegerRule implements Rule
{
    protected $min;
    protected $max;

    public function __construct($min = null, $max = null)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function passes($value): bool
    {
        if ($value === null || $value === '') return false;
        // filter_var returns int(0) for '0', so strict comparison against false is required
        $filtered = filter_var($value, FILTER_VALIDATE_INT);
        if ($filtered === false && !is_int($value)) return false;
        $int = (int)$value;
        if (!is_null($this->min) && $int < $this->min) return false;
        if (!is_null($this->max) && $int > $this->max) return false;
        return true;
    }

    public function error($atribute): string
    {
        if (!is_null($this->min) && !is_null($this->max)) {
            return "O campo $atribute deve ser um número inteiro entre {$this->min} e {$this->max}.";
        }
        if (!is_null($this->min)) {
            return "O campo $atribute deve ser um número inteiro maior ou igual a {$this->min}.";
        }
        return "O campo $atribute deve ser um número inteiro.";
    }
}

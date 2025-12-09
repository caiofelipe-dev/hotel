<?php

namespace App\Rules;

use Fmk\Interfaces\Rule;

class RangeRule implements Rule
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
        if (!is_numeric($value)) return false;
        $v = (float) $value;
        if (!is_null($this->min) && $v < $this->min) return false;
        if (!is_null($this->max) && $v > $this->max) return false;
        return true;
    }

    public function error($atribute): string
    {
        if (!is_null($this->min) && !is_null($this->max)) {
            return "O campo $atribute deve estar entre {$this->min} e {$this->max}.";
        }
        if (!is_null($this->min)) {
            return "O campo $atribute deve ser maior ou igual a {$this->min}.";
        }
        return "O campo $atribute deve ser numérico.";
    }
}

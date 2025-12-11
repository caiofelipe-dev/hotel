<?php

namespace App\Components;

use Fmk\Facades\Component;

class DataTableComponent extends Component {
    protected $columns;
    protected $rows;

    public function columns(array ...$columns) {
        foreach($columns as $c)
            $c = trim($c);
        $this->columns = $columns;
        return $this;
    }

    public function rows(...$rows) {
        foreach($rows as $r)
            $r = trim($r);
        
        
        $this->rows = $rows;
        return $this;
    }
    
}
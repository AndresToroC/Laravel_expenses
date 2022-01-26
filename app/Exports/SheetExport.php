<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Exports\CollectionExport;

class SheetExport implements WithMultipleSheets {
    use Exportable;

    protected $rows;

    public function __construct($rows = []) {
        $this->rows = $rows;
    }

    public function sheets(): array {
        $sheets = [];

        foreach ($this->rows as $key => $row) {
            $sheets[] = new CollectionExport($row['rows'], $row['header'], $row['title']);
        }

        return $sheets;
    }
}
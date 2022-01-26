<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CollectionExport implements FromCollection, WithHeadings, WithTitle
{
    protected $rows, $header, $title;

    public function __construct($rows = [], $header = [], $title = '') {
        $this->rows = $rows;
        $this->header = $header;
        $this->title = $title;
    }
    
    public function collection()
    {
        return collect($this->rows);
    }

    public function headings(): array {
        return $this->header;
    }

    public function title(): string {
        return $this->title;
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataAllExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $datas;
    protected $headerColumn;

    public function __construct($datas, $headerColumn)
    {
        $this->datas = $datas;
        $this->headerColumn = $headerColumn;
    }

    public function collection()
    {
        return $this->datas;
    }

    public function headings(): array
    {
        return $this->headerColumn;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

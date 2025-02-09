<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class InventoryExportCollection implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $inventories;

    public function __construct($inventories)
    {
        $this->inventories = $inventories;
    }

    public function collection()
    {
        return new Collection($this->inventories);
    }

    public function headings(): array
    {
        return ['ID', 'Producto', 'Cantidad', 'Tipo', 'Razón', 'Usuario', 'Fecha'];
    }
}

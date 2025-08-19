<?php

// File: app/Exports/ExcelExports.php ✅
namespace App\Exports;

use App\Models\CategoryProductModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExports implements FromCollection
{
    public function collection()
    {
        return CategoryProductModel::all();
    }
}


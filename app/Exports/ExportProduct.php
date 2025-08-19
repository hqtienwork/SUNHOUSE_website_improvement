<?php

// File: app/Exports/ExportProduct.php ✅
namespace App\Exports;

use App\Models\CategoryProductModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProduct implements FromCollection
{
    public function collection()
    {
        return CategoryProductModel::all();
    }
}


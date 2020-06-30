<?php

namespace App\Exports;

use App\Models\ScTypeReportCard;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportCardExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ScTypeReportCard::all();
    }
}

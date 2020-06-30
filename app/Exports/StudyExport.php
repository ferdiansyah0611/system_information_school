<?php

namespace App\Exports;

use App\Models\ScStudy;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudyExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ScStudy::all();
    }
}

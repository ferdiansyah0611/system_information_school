<?php

namespace App\Exports;

use App\Models\ScSchool;
use Maatwebsite\Excel\Concerns\FromCollection;

class SchoolExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ScSchool::all();
    }
}

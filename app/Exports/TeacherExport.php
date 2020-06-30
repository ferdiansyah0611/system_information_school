<?php

namespace App\Exports;

use App\Models\ScTeacher;
use Maatwebsite\Excel\Concerns\FromCollection;

class TeacherExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ScTeacher::all();
    }
}

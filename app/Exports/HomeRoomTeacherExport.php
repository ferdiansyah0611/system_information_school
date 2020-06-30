<?php

namespace App\Exports;

use App\Models\ScHomeRoomTeacher;
use Maatwebsite\Excel\Concerns\FromCollection;

class HomeRoomTeacherExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ScHomeRoomTeacher::all();
    }
}

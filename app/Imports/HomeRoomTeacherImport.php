<?php

namespace App\Imports;

use App\Models\ScHomeRoomTeacher;
use Maatwebsite\Excel\Concerns\ToModel;

class HomeRoomTeacherImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ScHomeRoomTeacher([
            'id' => rand(100000, 1000000),
            'sc_teacher_id' => $row[0],
            'sc_class_id' => $row[1],
            'start_period' => $row[2],
            'end_period' => $row[3],
        ]);
    }
}

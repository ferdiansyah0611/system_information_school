<?php

namespace App\Imports;

use App\Models\ScStudy;
use Maatwebsite\Excel\Concerns\ToModel;

class StudyImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ScStudy([
            'id' => rand(100000, 1000000),
            'sc_school_id' => $row[0],
            'sc_class_id' => $row[1],
            'sc_teacher_id' => $row[2],
            'name' => $row[3],
            'day' => $row[4],
            'time' => $row[5]
        ]);
    }
}

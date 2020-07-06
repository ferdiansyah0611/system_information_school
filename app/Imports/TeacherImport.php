<?php

namespace App\Imports;

use App\Models\ScTeacher;
use Maatwebsite\Excel\Concerns\ToModel;

class TeacherImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ScTeacher([
            'id' => rand(100000, 1000000),
            'user_id' => $row[0],
            'sc_school_id' => $row[1],
            'title' => $row[2],
            'graduate' => $row[3]
        ]);
    }
}

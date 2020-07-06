<?php

namespace App\Imports;

use App\Models\ScStudent;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ScStudent([
            'id' => rand(100000, 1000000),
            'user_id' => $row[0],
            'sc_school_id' => $row[1],
            'sc_class_id' => $row[2],
            'phone' => $row[3],
            'father' => $row[4],
            'mother' => $row[5],
            'work_father' => $row[6],
            'work_mother' => $row[7],
            'phone_father' => $row[8],
            'phone_mother' => $row[9],
            'generation' => $row[10]
        ]);
    }
}

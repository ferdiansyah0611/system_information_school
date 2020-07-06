<?php

namespace App\Imports;

use App\Models\ScSchool;
use Maatwebsite\Excel\Concerns\ToModel;

class SchoolImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ScSchool([
            'id' => rand(100000, 1000000),
            'user_id' => $row[0],
            'name' => $row[1],
            'description' => $row[2],
            'type' => $row[3]
        ]);
    }
}

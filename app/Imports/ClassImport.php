<?php

namespace App\Imports;

use App\Models\ScClass;
use Maatwebsite\Excel\Concerns\ToModel;

class ClassImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ScClass([
            'id' => rand(100000, 1000000),
            'sc_school_id' => $row[0],
            'name' => row[1]
        ]);
    }
}

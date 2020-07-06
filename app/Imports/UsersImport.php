<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'id' => rand(100000, 1000000),
            'sc_school_id' => $row[0],
            'name' => $row[1],
            'email' => $row[2],
            'nisn' => $row[3],
            'role' => $row[4],
            'location' => $row[5],
            'born' => $row[6],
            'avatar' => $row[7],
            'languange' => $row[8],
            'gender' => $row[9]
        ]);
    }
}

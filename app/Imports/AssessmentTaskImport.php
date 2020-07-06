<?php

namespace App\Imports;

use App\Models\ScAssessmentTask;
use Maatwebsite\Excel\Concerns\ToModel;

class AssessmentTaskImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ScAssessmentTask([
            'id' => rand(100000, 1000000),
            'sc_student_id' => $row[0],
            'title' => $row[1],
            'description' => $row[2],
            'score' => $row[3],
        ]);
    }
}

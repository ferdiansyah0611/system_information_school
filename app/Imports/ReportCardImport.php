<?php

namespace App\Imports;

use App\Models\ScTypeReportCard;
use Maatwebsite\Excel\Concerns\ToModel;

class ReportCardImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ScTypeReportCard([
            'id' => rand(100000, 1000000),
            'sc_home_room_teacher_id' => $row[0],
            'sc_student_id' => $row[1],
            'type' => $row[2],
            'period' => $row[3],
            'description' => $row[4],
            'absent_broken' => $row[5],
            'absent_permission' => $row[6],
            'absent_without_explanation' => $row[7],
            'personality_behavior' => $row[8],
            'personality_diligence' => $row[9],
            'personality_neatness' => $row[10]
        ]);
    }
}

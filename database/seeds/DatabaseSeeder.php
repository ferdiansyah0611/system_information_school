<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ScAssessmentTaskSeeder::class);
        $this->call(ScClassSeeder::class);
        $this->call(ScHomeRoomTeacherSeeder::class);
        $this->call(ScNoteSeeder::class);
        $this->call(ScReportCardElementarySeeder::class);
        $this->call(ScReportCardExtraCurricularSeeder::class);
        $this->call(ScReportCardJuniorSeeder::class);
        $this->call(ScReportCardSeniorSeeder::class);
        $this->call(ScSchoolSeeder::class);
        $this->call(ScStudentSeeder::class);
        $this->call(ScStudySeeder::class);
        $this->call(ScTeacherSeeder::class);
        $this->call(ScTypeReportCardSeeder::class);
    }
}
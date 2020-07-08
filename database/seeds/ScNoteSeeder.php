<?php

use Illuminate\Database\Seeder;
use App\models\ScNote;
class ScNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 11; $i++) {
            ScNote::create([
            	'user_id' => $i,
            	'title' => 'My Notes',
            	'note' => 'Laravel is modern framework php'
            ]);
        }
    }
}
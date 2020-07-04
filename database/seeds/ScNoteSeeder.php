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
        ScNote::create([
        	'user_id' => '1',
        	'title' => 'My Notes',
        	'note' => 'Laravel is modern framework php'
        ]);
    }
}
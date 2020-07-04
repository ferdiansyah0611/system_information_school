<?php

use Illuminate\Database\Seeder;
use App\Models\ScClass;
class ScClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScClass::create([
        	'sc_school_id' => '1',
        	'name' => 'SMK Letris Indonesia'
        ]);
    }
}

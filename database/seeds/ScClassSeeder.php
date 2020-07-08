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
        for ($i=1; $i < 11; $i++) {
            ScClass::create([
            	'sc_school_id' => $i,
            	'name' => 'SMK ' . $i
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::create([
            'code' => 'CO-1',
            'name' => 'Zumba inicial',
            'number_places' => 50,
            'start_hour' => '08:30',
            'end_hour' => '10:00',
            'start_date' => '2023-04-01'
        ]);
    }
}

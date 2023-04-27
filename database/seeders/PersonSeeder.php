<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Person::create([
            "code" => "PER-1",
            "dni" => "8000055",
            "iban" => "123456789",
            "gender" => Person::GENDER_MALE,
            "name" => "FULANITO",
            "last_name" => "PEREZ",
            "phone" => "555577777",
            "address" => "Calle 58",
            "country" => "España",
            "birth_date" => "1990-01-01"
        ]);
    }
}

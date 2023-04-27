<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Membership::create([
            "code" => "MEM-1",
            "duration" => 5,
            "price" => 190,
            "type" => Membership::MEMBERSHIP_TYPE_MONTH
        ]);
    }
}

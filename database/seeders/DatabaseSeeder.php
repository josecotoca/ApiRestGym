<?php

namespace Database\Seeders;

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
        $this->call(PersonSeeder::class);
        $this->call(MembershipSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(CustomerSeeder::class);
    }
}

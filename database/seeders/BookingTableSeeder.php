<?php

namespace Database\Seeders;

use App\Laravue\Faker;
use App\Models\Booking;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class BookingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Booking::factory()->count(50)->create();
    }
}

<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ['Active', 'In-Active'];
        $startingDate = $this->faker->dateTimeThisYear('+1 month');
        return [
            'pod_name' => Str::random(5),
            'user_name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber,
            'status' => $status[rand(0, 1)],
            'price' => $this->faker->randomNumber(4),
            'booking_date' => $startingDate,
            'booking_time' => $this->faker->time()
        ];
    }
}

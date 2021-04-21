<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('pod_name', 100);
            $table->string('user_name', 300);
            $table->string('phone', 50);
            $table->enum('status', ['Active', 'In-Active'])->default('Active');
            $table->integer('price')->default(0);
            $table->date('booking_date')->default(now());
            $table->time('booking_time')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}

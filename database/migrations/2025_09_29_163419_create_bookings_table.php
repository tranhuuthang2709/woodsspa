<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');
        $table->string('customer_phone');
        $table->integer('number_of_people')->default(1);
        $table->date('booking_date');
        $table->time('booking_time');
        $table->text('note')->nullable();
        $table->enum('status', ['pending', 'confirmed', 'cancelled', 'done'])->default('pending');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('bookings');
}

};

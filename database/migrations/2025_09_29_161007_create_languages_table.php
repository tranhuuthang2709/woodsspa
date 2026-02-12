<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('languages', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // Ví dụ: 'en', 'vi'
        $table->string('name');           // Ví dụ: 'English', 'Vietnamese'
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('languages');
}

};

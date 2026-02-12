<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('category_translations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->foreignId('language_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->unique(['category_id', 'language_id']); 
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('category_translations');
}

};

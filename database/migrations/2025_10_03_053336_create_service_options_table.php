<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('service_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->integer('duration'); // thời lượng (phút)

            // Giá VNĐ
            $table->decimal('price_vnd', 12, 0)->nullable();
            $table->decimal('sale_price_vnd', 12, 0)->nullable();

            // Giá USD
            $table->decimal('price_usd', 12, 2)->nullable();
            $table->decimal('sale_price_usd', 12, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_options');
    }
};

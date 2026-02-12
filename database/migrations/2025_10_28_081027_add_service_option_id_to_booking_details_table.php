<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('booking_details', function (Blueprint $table) {
            $table->unsignedBigInteger('service_option_id')->nullable()->after('service_id');
            $table->foreign('service_option_id')->references('id')->on('service_options')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('booking_details', function (Blueprint $table) {
            $table->dropForeign(['service_option_id']);
            $table->dropColumn('service_option_id');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->json('section3_fixed_card_images')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->dropColumn('section3_fixed_card_images');
        });
    }
};

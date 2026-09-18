<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->string('section3_heading')->nullable();
            $table->text('section3_description')->nullable();
            $table->string('section3_background_image')->nullable();
            $table->unsignedSmallInteger('section3_padding_y')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->dropColumn(['section3_heading', 'section3_description', 'section3_background_image', 'section3_padding_y']);
        });
    }
};

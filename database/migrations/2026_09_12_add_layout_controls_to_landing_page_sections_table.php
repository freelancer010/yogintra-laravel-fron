<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('landing_page_sections', function (Blueprint $table) {
            $table->string('image_position', 10)->default('left')->after('image_alt');
            $table->unsignedSmallInteger('padding_y')->default(48)->after('background_color');
            $table->unsignedSmallInteger('margin_y')->default(0)->after('padding_y');
        });
    }

    public function down(): void
    {
        Schema::table('landing_page_sections', function (Blueprint $table) {
            $table->dropColumn(['image_position', 'padding_y', 'margin_y']);
        });
    }
};

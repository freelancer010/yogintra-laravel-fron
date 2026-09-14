<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('landing_page_sections', function (Blueprint $table) {
            $table->string('background_mode', 10)->default('color')->after('background_color');
            $table->string('background_overlay_color', 20)->default('#000000')->after('background_parallax');
            $table->unsignedTinyInteger('background_overlay_opacity')->default(0)->after('background_overlay_color');
        });
    }

    public function down(): void
    {
        Schema::table('landing_page_sections', function (Blueprint $table) {
            $table->dropColumn(['background_mode', 'background_overlay_color', 'background_overlay_opacity']);
        });
    }
};

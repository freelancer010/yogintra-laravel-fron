<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('landing_page_sections', function (Blueprint $table) {
            $table->string('background_image')->nullable()->after('background_color');
            $table->string('background_position', 20)->default('center')->after('background_image');
            $table->boolean('background_parallax')->default(false)->after('background_position');
        });
    }

    public function down(): void
    {
        Schema::table('landing_page_sections', function (Blueprint $table) {
            $table->dropColumn(['background_image', 'background_position', 'background_parallax']);
        });
    }
};

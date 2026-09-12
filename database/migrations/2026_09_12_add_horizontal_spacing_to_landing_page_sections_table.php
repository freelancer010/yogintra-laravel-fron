<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void { Schema::table('landing_page_sections', function (Blueprint $table) { $table->unsignedSmallInteger('padding_x')->default(0)->after('image_position'); $table->unsignedSmallInteger('margin_x')->default(0)->after('padding_y'); }); }
    public function down(): void { Schema::table('landing_page_sections', function (Blueprint $table) { $table->dropColumn(['padding_x', 'margin_x']); }); }
};

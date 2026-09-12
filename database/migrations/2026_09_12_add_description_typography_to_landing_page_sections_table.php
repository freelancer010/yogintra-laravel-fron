<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void { Schema::table('landing_page_sections', function (Blueprint $table) { $table->string('description_color', 20)->default('#647b82')->after('heading_size'); $table->unsignedSmallInteger('description_size')->default(16)->after('description_color'); }); }
    public function down(): void { Schema::table('landing_page_sections', function (Blueprint $table) { $table->dropColumn(['description_color', 'description_size']); }); }
};

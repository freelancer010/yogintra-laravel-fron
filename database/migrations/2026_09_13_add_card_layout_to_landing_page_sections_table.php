<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void { Schema::table('landing_page_sections', fn (Blueprint $table) => $table->string('card_layout', 20)->default('stacked')->after('grid_columns')); }
    public function down(): void { Schema::table('landing_page_sections', fn (Blueprint $table) => $table->dropColumn('card_layout')); }
};

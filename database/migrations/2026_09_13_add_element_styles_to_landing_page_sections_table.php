<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void { Schema::table('landing_page_sections', fn (Blueprint $table) => $table->json('element_styles')->nullable()->after('text_align')); }
    public function down(): void { Schema::table('landing_page_sections', fn (Blueprint $table) => $table->dropColumn('element_styles')); }
};

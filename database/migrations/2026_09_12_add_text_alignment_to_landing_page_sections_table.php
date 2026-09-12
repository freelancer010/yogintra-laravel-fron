<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void { Schema::table('landing_page_sections', fn (Blueprint $table) => $table->string('text_align', 10)->default('left')->after('description_size')); }
    public function down(): void { Schema::table('landing_page_sections', fn (Blueprint $table) => $table->dropColumn('text_align')); }
};

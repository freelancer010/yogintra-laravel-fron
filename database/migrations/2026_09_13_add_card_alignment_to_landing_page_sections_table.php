<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::table('landing_page_sections', fn (Blueprint $table) => $table->string('card_alignment', 10)->default('center')->after('card_layout')); }
    public function down(): void { Schema::table('landing_page_sections', fn (Blueprint $table) => $table->dropColumn('card_alignment')); }
};

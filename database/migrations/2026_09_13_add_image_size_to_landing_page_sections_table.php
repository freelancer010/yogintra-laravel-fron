<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::table('landing_page_sections', fn (Blueprint $table) => $table->unsignedSmallInteger('image_size')->default(42)->after('image_position')); } public function down(): void { Schema::table('landing_page_sections', fn (Blueprint $table) => $table->dropColumn('image_size')); } };

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::table('landing_page_sections', function (Blueprint $table) { $table->string('text_color', 20)->default('#183c45')->after('background_color'); $table->unsignedSmallInteger('heading_size')->default(32)->after('text_color'); }); }
 public function down(): void { Schema::table('landing_page_sections', function (Blueprint $table) { $table->dropColumn(['text_color','heading_size']); }); }
};

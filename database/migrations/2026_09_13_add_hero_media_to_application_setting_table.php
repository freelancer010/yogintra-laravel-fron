<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->string('hero_media_type', 16)->default('slider')->after('app_id');
            $table->string('hero_video')->nullable()->after('hero_media_type');
        });
    }

    public function down(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->dropColumn(['hero_media_type', 'hero_video']);
        });
    }
};

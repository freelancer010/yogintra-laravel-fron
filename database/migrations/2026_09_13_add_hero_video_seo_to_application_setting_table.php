<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->string('hero_video_title')->nullable()->after('hero_video');
            $table->text('hero_video_description')->nullable()->after('hero_video_title');
        });
    }

    public function down(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->dropColumn(['hero_video_title', 'hero_video_description']);
        });
    }
};

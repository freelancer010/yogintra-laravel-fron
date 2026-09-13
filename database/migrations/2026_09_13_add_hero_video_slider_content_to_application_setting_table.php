<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->string('hero_video_heading')->nullable()->after('hero_video_description');
            $table->string('hero_video_sub_heading')->nullable()->after('hero_video_heading');
            $table->string('hero_video_btn_name')->nullable()->after('hero_video_sub_heading');
            $table->string('hero_video_btn_link')->nullable()->after('hero_video_btn_name');
            $table->string('hero_video_text_direction', 16)->default('left')->after('hero_video_btn_link');
        });
    }

    public function down(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->dropColumn(['hero_video_heading', 'hero_video_sub_heading', 'hero_video_btn_name', 'hero_video_btn_link', 'hero_video_text_direction']);
        });
    }
};

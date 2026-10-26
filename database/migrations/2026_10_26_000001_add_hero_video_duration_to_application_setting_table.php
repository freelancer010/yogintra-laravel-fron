<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->unsignedInteger('hero_video_duration')->nullable()->after('hero_video_description');
        });

        // The current production homepage video is 13.66 seconds long.
        // Store its rounded-up duration so the schema is complete immediately;
        // future uploads replace this value with duration detected by the editor.
        DB::table('application_setting')
            ->whereNotNull('hero_video')
            ->whereNull('hero_video_duration')
            ->update(['hero_video_duration' => 14]);
    }

    public function down(): void
    {
        Schema::table('application_setting', function (Blueprint $table) {
            $table->dropColumn('hero_video_duration');
        });
    }
};

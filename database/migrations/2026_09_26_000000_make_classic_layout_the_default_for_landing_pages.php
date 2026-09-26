<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('new_landing_page', function (Blueprint $table) {
            $table->boolean('use_classic_layout')->default(true)->change();
        });

        // Keep all existing city pages on the one supported public layout,
        // rather than allowing a legacy page to render until it is edited.
        $slugs = DB::table('new_landing_page')
            ->where('use_classic_layout', false)
            ->pluck('page_slug');

        DB::table('new_landing_page')
            ->where('use_classic_layout', false)
            ->update(['use_classic_layout' => true]);

        foreach ($slugs as $slug) {
            Cache::forget('landing-page.data.' . sha1($slug));
        }
    }

    public function down(): void
    {
        Schema::table('new_landing_page', function (Blueprint $table) {
            $table->boolean('use_classic_layout')->default(false)->change();
        });
    }
};

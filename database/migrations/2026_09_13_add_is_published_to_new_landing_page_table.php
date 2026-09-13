<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('new_landing_page', function (Blueprint $table) {
            $table->boolean('is_published')->default(true)->after('page_slug');
        });
    }

    public function down(): void
    {
        Schema::table('new_landing_page', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }
};

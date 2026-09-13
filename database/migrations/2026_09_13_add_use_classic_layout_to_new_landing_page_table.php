<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('new_landing_page', function (Blueprint $table) {
            $table->boolean('use_classic_layout')->default(false)->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('new_landing_page', function (Blueprint $table) {
            $table->dropColumn('use_classic_layout');
        });
    }
};

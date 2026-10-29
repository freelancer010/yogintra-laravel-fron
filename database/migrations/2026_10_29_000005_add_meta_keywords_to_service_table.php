<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('service') || Schema::hasColumn('service', 'service_meta_keywords')) {
            return;
        }

        Schema::table('service', function (Blueprint $table) {
            $table->string('service_meta_keywords', 500)->nullable()->after('service_meta_description');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('service') || ! Schema::hasColumn('service', 'service_meta_keywords')) {
            return;
        }

        Schema::table('service', function (Blueprint $table) {
            $table->dropColumn('service_meta_keywords');
        });
    }
};

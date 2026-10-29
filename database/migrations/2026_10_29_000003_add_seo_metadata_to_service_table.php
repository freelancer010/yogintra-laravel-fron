<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('service')) {
            return;
        }

        Schema::table('service', function (Blueprint $table) {
            if (!Schema::hasColumn('service', 'service_meta_title')) {
                $table->string('service_meta_title', 255)->nullable()->after('service_image_title');
            }
            if (!Schema::hasColumn('service', 'service_meta_description')) {
                $table->string('service_meta_description', 500)->nullable()->after('service_meta_title');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('service')) {
            return;
        }

        Schema::table('service', function (Blueprint $table) {
            if (Schema::hasColumn('service', 'service_meta_description')) {
                $table->dropColumn('service_meta_description');
            }
            if (Schema::hasColumn('service', 'service_meta_title')) {
                $table->dropColumn('service_meta_title');
            }
        });
    }
};

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
            if (!Schema::hasColumn('service', 'service_image_alt')) {
                $table->string('service_image_alt', 255)->nullable()->after('service_image');
            }
            if (!Schema::hasColumn('service', 'service_image_title')) {
                $table->string('service_image_title', 255)->nullable()->after('service_image_alt');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('service')) {
            return;
        }

        Schema::table('service', function (Blueprint $table) {
            if (Schema::hasColumn('service', 'service_image_title')) {
                $table->dropColumn('service_image_title');
            }
            if (Schema::hasColumn('service', 'service_image_alt')) {
                $table->dropColumn('service_image_alt');
            }
        });
    }
};

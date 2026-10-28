<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('gallery')) {
            return;
        }

        Schema::table('gallery', function (Blueprint $table) {
            if (!Schema::hasColumn('gallery', 'gallery_image_alt')) {
                $table->string('gallery_image_alt', 255)->nullable()->after('gallery_image');
            }
            if (!Schema::hasColumn('gallery', 'gallery_image_title')) {
                $table->string('gallery_image_title', 255)->nullable()->after('gallery_image_alt');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('gallery')) {
            return;
        }

        Schema::table('gallery', function (Blueprint $table) {
            if (Schema::hasColumn('gallery', 'gallery_image_title')) {
                $table->dropColumn('gallery_image_title');
            }
            if (Schema::hasColumn('gallery', 'gallery_image_alt')) {
                $table->dropColumn('gallery_image_alt');
            }
        });
    }
};

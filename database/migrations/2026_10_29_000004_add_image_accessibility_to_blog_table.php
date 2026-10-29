<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('blog')) {
            return;
        }

        Schema::table('blog', function (Blueprint $table) {
            if (!Schema::hasColumn('blog', 'blog_image_alt')) {
                $table->string('blog_image_alt', 255)->nullable()->after('blog_image');
            }
            if (!Schema::hasColumn('blog', 'blog_image_title')) {
                $table->string('blog_image_title', 255)->nullable()->after('blog_image_alt');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('blog')) {
            return;
        }

        Schema::table('blog', function (Blueprint $table) {
            if (Schema::hasColumn('blog', 'blog_image_title')) {
                $table->dropColumn('blog_image_title');
            }
            if (Schema::hasColumn('blog', 'blog_image_alt')) {
                $table->dropColumn('blog_image_alt');
            }
        });
    }
};

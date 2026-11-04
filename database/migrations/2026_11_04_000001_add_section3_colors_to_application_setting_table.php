<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('application_setting')) {
            return;
        }

        Schema::table('application_setting', function (Blueprint $table) {
            if (! Schema::hasColumn('application_setting', 'section3_heading_color')) {
                $table->string('section3_heading_color', 7)->nullable()->after('section3_description');
            }

            if (! Schema::hasColumn('application_setting', 'section3_description_color')) {
                $table->string('section3_description_color', 7)->nullable()->after('section3_heading_color');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('application_setting')) {
            return;
        }

        $columns = array_values(array_filter([
            'section3_heading_color',
            'section3_description_color',
        ], static fn (string $column): bool => Schema::hasColumn('application_setting', $column)));

        if ($columns !== []) {
            Schema::table('application_setting', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};

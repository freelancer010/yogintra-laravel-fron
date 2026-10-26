<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('application_setting')) {
            return;
        }

        $missing = array_filter([
            'app_address_locality' => ! Schema::hasColumn('application_setting', 'app_address_locality'),
            'app_address_region' => ! Schema::hasColumn('application_setting', 'app_address_region'),
            'app_postal_code' => ! Schema::hasColumn('application_setting', 'app_postal_code'),
            'app_address_country' => ! Schema::hasColumn('application_setting', 'app_address_country'),
        ]);

        if ($missing !== []) {
            Schema::table('application_setting', function (Blueprint $table) use ($missing) {
                if (isset($missing['app_address_locality'])) {
                    $table->string('app_address_locality', 120)->nullable();
                }
                if (isset($missing['app_address_region'])) {
                    $table->string('app_address_region', 120)->nullable();
                }
                if (isset($missing['app_postal_code'])) {
                    $table->string('app_postal_code', 20)->nullable();
                }
                if (isset($missing['app_address_country'])) {
                    $table->string('app_address_country', 2)->nullable();
                }
            });
        }

        DB::table('application_setting')
            ->where(function ($query) {
                $query->whereNull('app_address_country')
                    ->orWhere('app_address_country', '');
            })
            ->update(['app_address_country' => 'IN']);

        DB::table('application_setting')
            ->select(['app_id', 'app_address', 'app_postal_code'])
            ->orderBy('app_id')
            ->each(function ($setting) {
                if (filled($setting->app_postal_code) || ! filled($setting->app_address)) {
                    return;
                }

                if (preg_match('/\b[1-9][0-9]{5}\b/', (string) $setting->app_address, $matches)) {
                    DB::table('application_setting')
                        ->where('app_id', $setting->app_id)
                        ->update(['app_postal_code' => $matches[0]]);
                }
            });
    }

    public function down(): void
    {
        if (! Schema::hasTable('application_setting')) {
            return;
        }

        $columns = array_values(array_filter([
            'app_address_locality',
            'app_address_region',
            'app_postal_code',
            'app_address_country',
        ], static fn (string $column): bool => Schema::hasColumn('application_setting', $column)));

        if ($columns !== []) {
            Schema::table('application_setting', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};

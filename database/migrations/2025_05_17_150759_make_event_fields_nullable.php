<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('event', function (Blueprint $table) {
            $table->text('ticket_short_des_foreigner')->nullable()->change();
            $table->text('ticket_short_des_indian')->nullable()->change();
            $table->string('addon_name')->nullable()->change();
            $table->string('addon_price')->nullable()->change();
            $table->text('ticket_price_foreigner')->nullable()->change();
            $table->text('ticket_capacity_foreigner')->nullable()->change();
            $table->text('ticket_d_qnty_foreigner')->nullable()->change();
            $table->text('ticket_r_qnty_foreigner')->nullable()->change();
            $table->text('ticket_price_indian')->nullable()->change();
            $table->text('ticket_capacity_indian')->nullable()->change();
            $table->text('ticket_d_qnty_indian')->nullable()->change();
            $table->text('ticket_r_qnty_indian')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('event', function (Blueprint $table) {
            $table->text('ticket_short_des_foreigner')->nullable(false)->change();
            $table->text('ticket_short_des_indian')->nullable(false)->change();
            $table->string('addon_name')->nullable(false)->change();
            $table->string('addon_price')->nullable(false)->change();
            $table->text('ticket_price_foreigner')->nullable(false)->change();
            $table->text('ticket_capacity_foreigner')->nullable(false)->change();
            $table->text('ticket_d_qnty_foreigner')->nullable(false)->change();
            $table->text('ticket_r_qnty_foreigner')->nullable(false)->change();
            $table->text('ticket_price_indian')->nullable(false)->change();
            $table->text('ticket_capacity_indian')->nullable(false)->change();
            $table->text('ticket_d_qnty_indian')->nullable(false)->change();
            $table->text('ticket_r_qnty_indian')->nullable(false)->change();
        });
    }
};

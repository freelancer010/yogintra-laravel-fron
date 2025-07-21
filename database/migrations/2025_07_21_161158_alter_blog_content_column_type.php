<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blog', function (Blueprint $table) {
            $table->longText('blog_content')->change();
        });
    }

    public function down()
    {
        Schema::table('blog', function (Blueprint $table) {
            $table->text('blog_content')->change(); // Optional rollback
        });
    }

};

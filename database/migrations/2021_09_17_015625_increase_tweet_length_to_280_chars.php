<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseTweetLengthTo280Chars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->string('text', 280)->nullable()->change();
        });

        Schema::table('tweets', function (Blueprint $table) {
            $table->string('tweet_text', 280)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->string('text')->nullable()->change();
        });

        Schema::table('tweets', function (Blueprint $table) {
            $table->string('tweet_text')->nullable()->change();
        });
    }
}

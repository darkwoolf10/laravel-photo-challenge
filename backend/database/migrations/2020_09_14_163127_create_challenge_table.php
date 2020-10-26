<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->string('context');
            $table->bigInteger('author')->unsigned();
            $table->bigInteger('executor')->unsigned();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::table('challenges', function (Blueprint $table) {
            $table->foreign('executor')
                ->references('id')
                ->on('users');
        });

        Schema::table('challenges', function (Blueprint $table) {
            $table->foreign('author')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenge');
    }
}

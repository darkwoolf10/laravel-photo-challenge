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
            $table->bigInteger('author_id')->unsigned();
            $table->bigInteger('executor_id')->unsigned();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::table('challenges', function (Blueprint $table) {
            $table->foreign('executor_id')
                ->references('id')
                ->on('users');

            $table->foreign('author_id')
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

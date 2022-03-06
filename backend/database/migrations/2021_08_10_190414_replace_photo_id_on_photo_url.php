<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplacePhotoIdOnPhotoUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropForeign(['photo_id']);
            $table->dropColumn('photo_id');
            $table->string('photo_url')->nullable();
        });

        Schema::dropIfExists('photos');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->bigInteger('author_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->foreign('author_id')
                ->references('id')
                ->on('users');
        });

        Schema::table('challenges', function (Blueprint $table) {
            $table->bigInteger('photo_id')->unsigned()->nullable();
            $table->dropColumn('photo_url');

            $table->foreign('photo_id')
                ->references('id')
                ->on('photos');
        });
    }
}

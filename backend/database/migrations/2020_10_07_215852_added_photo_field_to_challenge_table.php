<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedPhotoFieldToChallengeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->bigInteger('photo_id')->unsigned()->nullable();

            $table->foreign('photo_id')
                ->references('id')
                ->on('photos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('challenge', function (Blueprint $table) {
            $table->dropForeign('photo_id');
            $table->dropColumn('photo_id');
        });
    }
}

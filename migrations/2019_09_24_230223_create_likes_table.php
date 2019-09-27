<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Envant\Likes\Like;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $userClass = Like::getAuthModelName();
        $usersTable = (new $userClass())->getTable();

        Schema::create(Like::getModel()->getTable(), function (Blueprint $table) use ($usersTable) {
            $table->bigIncrements('id');
            $table->morphs('model');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on($usersTable)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(Like::getModel()->getTable());
    }
}
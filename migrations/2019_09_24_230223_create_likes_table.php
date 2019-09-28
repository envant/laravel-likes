<?php

use Envant\Likes\Like;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     * @throws \Exception
     */
    public function up()
    {
        /** @var \Illuminate\Database\Eloquent\Model $userClass */
        $userClass = Like::getAuthModelName();

        /** @var \Illuminate\Database\Eloquent\Model $userModel */
        $userModel = new $userClass();

        Schema::create(Like::getModel()->getTable(), function (Blueprint $table) use ($userModel) {
            $table->bigIncrements('id');

            $table->morphs('model');
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references($userModel->getKeyName())->on($userModel->getTable())
                ->onDelete('cascade');

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

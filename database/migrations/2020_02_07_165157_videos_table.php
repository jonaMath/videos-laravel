<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id', 255);
            $table->integer('user_id', 255)->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title', 255);
            $table->text('description');
            $table->string('status', 20);
            $table->string('image', 255);
            $table->string('video_path', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}

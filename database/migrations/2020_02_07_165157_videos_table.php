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
        DB::statement('
            CREATE TABLE videos (
                id int(255) auto_increment not null,
                user_id int(255),
                title varchar(255),
                description text,                
                status varchar(20),
                image varchar(255),
                video_path varchar(255),
                created_at datetime not null default CURRENT_TIMESTAMP,
                updated_at datetime not null default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                FOREIGN KEY (user_id) REFERENCES users(id)
            );
        ');
        /*
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id', 255);
            $table->integer('user_id', 255)->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title', 255);
            $table->text('description');
            $table->string('status', 20);
            $table->string('image', 255);
            $table->string('video_path', 255);
            $table->timestamps();
        });*/
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

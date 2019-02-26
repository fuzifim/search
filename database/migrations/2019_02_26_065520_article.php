<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Article extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',255)->nullable();
            $table->string('title',255)->nullable();
            $table->string('base_64')->index();
            $table->mediumText('description')->nullable();
            $table->mediumText('image')->nullable();
            $table->string('author',255)->nullable();
            $table->mediumText('source')->nullable();
            $table->string('region',25)->nullable();
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
        Schema::dropIfExists('article');
    }
}

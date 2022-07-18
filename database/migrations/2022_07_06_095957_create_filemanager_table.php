<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filemanager', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('filepath');
            $table->string('filesize')->nullable();
            $table->string('model')->nullable();
            $table->unsignedBigInteger('user_id')->unsigned()->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filemanager');
    }
};

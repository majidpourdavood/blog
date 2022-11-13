<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable();
            $table->boolean('active')->default(false)->nullable();
            $table->boolean('type')->default(false)->nullable();
            $table->string('poster')->nullable();
            $table->string('file')->nullable();

            $table->integer('fileable_id')->nullable();
            $table->string('fileable_type')->nullable();

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
        Schema::dropIfExists('files');
    }
}

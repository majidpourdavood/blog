<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug'); //web-developer
            $table->string('name'); //Web Developer
            $table->text('body'); //Web Developer
            $table->timestamps();
        });


        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('permission_id')->unsigned();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('SET NULL');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('SET NULL');

            //SETTING THE PRIMARY KEYS
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create('users_roles', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('SET NULL');

            //SETTING THE PRIMARY KEYS
            $table->primary(['user_id', 'role_id']);
        });

        Schema::create('users_permissions', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('permission_id')->unsigned();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('SET NULL');

//SETTING THE PRIMARY KEYS
            $table->primary(['user_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users_permissions');
        Schema::dropIfExists('users_roles');
        Schema::dropIfExists('roles_permissions');
    }
}

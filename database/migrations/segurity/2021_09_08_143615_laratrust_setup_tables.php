<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class LaratrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::connection('segurity')->create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes()->nullable();
            $table->timestamps();
        });

        // Create table for storing permissions
        Schema::connection('segurity')->create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes()->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users and teams (Many To Many Polymorphic)
        Schema::connection('segurity')->create('role_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
            $table->string('user_type');

            $table->foreign('role_id')->references('id')->on('segurity.roles')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // Create table for associating permissions to users (Many To Many Polymorphic)
        Schema::connection('segurity')->create('permission_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('user_id');
            $table->string('user_type');

            $table->foreign('permission_id')->references('id')->on('segurity.permissions')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::connection('segurity')->create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')->references('id')->on('segurity.permissions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('role_id')->references('id')->on('segurity.roles')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        DB::table('segurity.roles')->insert(
            [
                'name' => 'admin',
                'display_name' => 'Administrador',
                'description' => 'Administrador del sistema'
            ]
        );

        DB::table('segurity.role_user')->insert(
            [
                [
                    'role_id' => 1,
                    'user_id' => 1,
                    'user_type' => App\Models\User::class
                ],
                [
                    'role_id' => 1,
                    'user_id' => 2,
                    'user_type' => App\Models\User::class
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
}

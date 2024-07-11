<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('segurity')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('cedula');
            $table->string('password');
            $table->unsignedTinyInteger('status')->default(1)->comment('0- Eliminado, 1- Activo, 2- Inactivo');
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->rememberToken();

            $table->timestamps();
        });

        DB::table('segurity.users')->insert(
            [
                [
                    'username' => 'root', 'name' => 'Root', 'email' => 'vm.desarrollo@gmail.com',
                    'password' => Hash::make('12345678'), 'cedula' => 'V00000000'
                ],
                [
                    'username' => 'admin', 'name' => 'Administrador', 'email' => 'vmdesarrollo@gmail.com',
                    'password' => Hash::make('12345678'), 'cedula' => 'V00000000'
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('segurity')->dropIfExists('users');
    }
}

<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 255)->unique();
            $table->string('name', 255)->default('');
            $table->string('password', 255);
            $table->string('gender', 50)->default('');
            $table->foreignId('role_id')->default(0);
            $table->timestamps();
        });

        $user = new User();
        $user->name = "Jihan Lugas";
        $user->email = 'jihanlugas2@gmail.com';
        $user->gender = 'MALE';
        $user->role_id = 1;
        $user->password = Hash::make('123456');
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

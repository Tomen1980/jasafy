<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateUsersTableForEnumRole extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom role sebagai enum
            $table->enum('role', ['admin', 'user', 'editor'])->default('user');
        });

        if (DB::getDriverName() === 'sqlite') {
            // Lakukan proses untuk SQLite
            DB::transaction(function () {
                Schema::create('users_temp', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('email')->unique();
                    $table->timestamp('email_verified_at')->nullable();
                    $table->string('password');
                    $table->rememberToken();
                    $table->timestamps();
                    $table->string('username')->unique();
                    $table->text('description')->nullable();
                    $table->enum('role', ['admin', 'user', 'editor'])->default('user');
                });

                DB::statement('INSERT INTO users_temp SELECT id, name, email, email_verified_at, password, remember_token, created_at, updated_at, username, description, "user" FROM users');

                Schema::drop('users');

                Schema::rename('users_temp', 'users');
            });
        } else {
            Schema::table('users', function (Blueprint $table) {
                // Hapus foreign key dan kolom role_id jika tidak menggunakan SQLite
                $table->dropForeign(['role_id']);
                $table->dropColumn('role_id');
            });
        }
    }

    public function down()
    {
        if (DB::getDriverName() === 'sqlite') {
            // Lakukan proses rollback untuk SQLite
            DB::transaction(function () {
                Schema::create('users_temp', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('email')->unique();
                    $table->timestamp('email_verified_at')->nullable();
                    $table->string('password');
                    $table->rememberToken();
                    $table->timestamps();
                    $table->text('description')->nullable();
                    $table->foreignId('role_id')->constrained()->onDelete('cascade');
                });

                DB::statement('INSERT INTO users_temp SELECT id, name, email, email_verified_at, password, remember_token, created_at, updated_at, username, description, NULL FROM users');

                Schema::drop('users');

                Schema::rename('users_temp', 'users');
            });
        } else {
            Schema::table('users', function (Blueprint $table) {
                // Hapus kolom role
                $table->dropColumn('role');

                // Tambahkan kembali kolom role_id jika tidak menggunakan SQLite
                $table->foreignId('role_id')->constrained()->onDelete('cascade');
            });
        }
    }
}


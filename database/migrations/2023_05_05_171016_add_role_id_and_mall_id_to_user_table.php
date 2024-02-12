<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->default(2);
            $table->unsignedBigInteger('id_mall');
            $table->foreign('id_mall')->references('id')->on('malls');
        });

        DB::table('malls')->insert([
            ['id' => 1, 'nombre' => 'Mall Vivo San Fernando', 'created_at' => null, 'updated_at' => null],
            ['id' => 2, 'nombre' => 'Mall Vivo Coquimbo', 'created_at' => null, 'updated_at' => null],
            ['id' => 3, 'nombre' => 'Mall Vivo Trapenses', 'created_at' => null, 'updated_at' => null],
            ['id' => 4, 'nombre' => 'Mall Vivo Panorámico', 'created_at' => null, 'updated_at' => null],
        ]);

        DB::table('users')->insert([
            ['id' => 1,'name' => 'Jose Cornejo Ferreira','email' => 'jcornejo@dmtech.cl','email_verified_at' => null,'password' => '$2y$10$Zuck.Glf2A4/tes.2SQqKu8tswwAUWtwjeWoRtORQbZYrZ/KvEOIa','remember_token' => null,'created_at' => '2022-11-08 05:09:15','updated_at' => '2022-12-19 21:04:12','id_mall' => 1,'role_id' => 2],
            ['id' => 3,'name' => 'Jose Cornejo','email' => 'jos.cornejof@duocuc.cl','email_verified_at' => null,'password' => '$2y$10$mJAZeUIKk7HlmAmlJimG2OGzEzkEuGdrr51Z19sejJgSNbjkZV2my','remember_token' => null,'created_at' => '2023-04-28 21:09:14','updated_at' => '2023-05-04 21:54:23','id_mall' => 2,'role_id' => 1]
        ]);
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role_id', 'mall_id']);
        });
    }
};

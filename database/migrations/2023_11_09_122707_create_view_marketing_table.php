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
        Schema::create('view_marketing', function (Blueprint $table) {
            $table->id();
            $table->integer('mall_id');
            $table->integer('entrada_marketing_id');
            $table->string('titulo_entrada');
            $table->boolean('estado');
            $table->boolean('eliminado');
            $table->timestamp('deleted_at');
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
        Schema::dropIfExists('view_marketing');
    }
};

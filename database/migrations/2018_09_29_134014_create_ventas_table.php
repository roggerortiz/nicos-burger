<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('producto', 50);
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('cantidad')->default(1);
            $table->unsignedInteger('producto_id');
            $table->unsignedInteger('registro_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict');
            $table->foreign('registro_id')->references('id')->on('registros')->onDelete('restrict');
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
        Schema::dropIfExists('ventas');
    }
}

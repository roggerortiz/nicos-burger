<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 50);
            $table->unsignedInteger('cantidad')->default(1);
            $table->decimal('monto', 10, 2);
            $table->integer('signo');
            $table->boolean('es_gasto')->default(false);
            $table->unsignedInteger('producto_id')->nullable();
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
        Schema::dropIfExists('movimientos');
    }
}

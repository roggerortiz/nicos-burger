<?php

use App\Movimiento;
use Illuminate\Database\Seeder;

class MovimientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movimiento::where('es_gasto', false)->get()->each(function($movimiento) {
            $movimiento->total = $movimiento->cantidad * $movimiento->precio;
            $movimiento->save();
        });

        Movimiento::where('es_gasto', true)->get()->each(function($movimiento) {
            $movimiento->total = $movimiento->precio;
            $movimiento->cantidad = null;
            $movimiento->precio = null;
            $movimiento->save();
        });
    }
}

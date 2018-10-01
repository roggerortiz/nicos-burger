<?php

use App\Insumo;
use Illuminate\Database\Seeder;

class InsumosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Insumo::create(['nombre' => 'Pan', 'precio' => '0.30']);
        Insumo::create(['nombre' => 'Huevo', 'precio' => '0.30']);
        Insumo::create(['nombre' => 'Jamón', 'precio' => '0.30']);
        Insumo::create(['nombre' => 'Queso', 'precio' => '0.30']);
        Insumo::create(['nombre' => 'Hot Dog', 'precio' => '0.30']);
        Insumo::create(['nombre' => 'Pollo', 'precio' => '0.30']);
        Insumo::create(['nombre' => 'Carne', 'precio' => '0.30']);
        Insumo::create(['nombre' => 'Chorizo', 'precio' => '0.30']);
        Insumo::create(['nombre' => 'Tocino', 'precio' => '0.30']);
        Insumo::create(['nombre' => 'Chuleta', 'precio' => '0.30']);
    }
}

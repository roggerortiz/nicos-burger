<?php

use App\Categoria;
use App\Producto;
use Illuminate\Database\Seeder;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = Categoria::create(['nombre' => 'Productos']);
        Producto::create(['nombre' => 'Hamburguesa Simple', 'precio' => '3.50', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Hamburguesa Royal', 'precio' => '4.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Hamburguesa Cheese', 'precio' => '4.50', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Hamburguesa Doble', 'precio' => '5.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Chorihuevo', 'precio' => '5.50', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Matahambre', 'precio' => '7.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Hamburguesa Nico', 'precio' => '10.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Super Nico', 'precio' => '13.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Salchipapa', 'precio' => '4.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Salchipollo', 'precio' => '7.00', 'categoria_id' => $categoria->id]);

        $categoria = Categoria::create(['nombre' => 'Agregados']);
        Producto::create(['nombre' => 'Huevo', 'precio' => '1.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Jamón', 'precio' => '1.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Queso', 'precio' => '1.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Hot Dog', 'precio' => '1.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Pollo', 'precio' => '2.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Carne', 'precio' => '2.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Chorizo', 'precio' => '2.00', 'categoria_id' => $categoria->id]);
        Producto::create(['nombre' => 'Tocino', 'precio' => '2.00', 'categoria_id' => $categoria->id]);

        $categoria = Categoria::create(['nombre' => 'Bebidas']);
        Producto::create(['nombre' => 'Chicha Morada', 'precio' => '1.00', 'categoria_id' => $categoria->id]);
    }
}

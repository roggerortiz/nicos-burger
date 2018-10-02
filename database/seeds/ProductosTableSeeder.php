<?php

use App\Categoria;
use App\InsumoProducto;
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
        //Categorias y Productos
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

        // Insumos
        Producto::create(['nombre' => 'Pan', 'precio' => '0.30', 'es_insumo' => true]);
        Producto::create(['nombre' => 'Huevo', 'precio' => '0.30', 'es_insumo' => true]);
        Producto::create(['nombre' => 'Jamón', 'precio' => '0.30', 'es_insumo' => true]);
        Producto::create(['nombre' => 'Queso', 'precio' => '0.30', 'es_insumo' => true]);
        Producto::create(['nombre' => 'Hot Dog', 'precio' => '0.30', 'es_insumo' => true]);
        Producto::create(['nombre' => 'Pollo', 'precio' => '0.30', 'es_insumo' => true]);
        Producto::create(['nombre' => 'Carne', 'precio' => '0.30', 'es_insumo' => true]);
        Producto::create(['nombre' => 'Chorizo', 'precio' => '0.30', 'es_insumo' => true]);
        Producto::create(['nombre' => 'Tocino', 'precio' => '0.30', 'es_insumo' => true]);
        Producto::create(['nombre' => 'Chuleta', 'precio' => '0.30', 'es_insumo' => true]);

        //Insumos de Producto
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 20, 'producto_id' => 1]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 20, 'producto_id' => 2]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 20, 'producto_id' => 3]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 20, 'producto_id' => 4]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 20, 'producto_id' => 5]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 20, 'producto_id' => 6]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 20, 'producto_id' => 7]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 20, 'producto_id' => 8]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 21, 'producto_id' => 11]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 22, 'producto_id' => 12]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 23, 'producto_id' => 13]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 24, 'producto_id' => 14]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 25, 'producto_id' => 15]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 26, 'producto_id' => 16]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 27, 'producto_id' => 17]);
        InsumoProducto::create(['cantidad' => 1, 'insumo_id' => 28, 'producto_id' => 18]);
    }
}

<?php

/*
    Actualizar las lineas factory(Product::class, 5)->create(); por Product::factory(5)->create(); ya que factory pasa a ser un
    metodo propio del modelo;
*/

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(3)->create();
    }
}

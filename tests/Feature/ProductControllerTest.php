<?php
/*  Notas a considerar:
    
    En la version de laravel 9 se deben modificar los archivos correspondientes a los request de cada modelo para realizar las acciones 'create' y 'update'
    en este caso serian StoreProductRequest y UpdateProductRequest se debe borrar completamente el metodo authorize para poder realizar las actividades de
    la clase 3, de igual forma actualizar las lineas factory(Product::class, 5)->create(); por Product::factory(5)->create(); ya que factory pasa a ser un
    metodo propio del modelo;

*/

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCotrollerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_index()
    {
        Product::factory(5)->create();

        $response = $this->getJson('/api/products');

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $response->assertJsonCount(5);
    }
    
    public function test_create_new_product()
    {
        $data = [
            'name' => 'Hola',
            'price' => 1000,
        ];
        $response = $this->postJson('/api/products', $data);
             
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $data);
    }

    public function test_update_product()
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $data = [
            'name' => 'Update Product',
            'price' => 20000,
        ];

        $response = $this->patchJson("/api/products/{$product->getKey()}", $data);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_show_product()
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->getKey()}");

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }
    
    public function test_delete_product()
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->getKey()}");

        $response->assertSuccessful();
    }
}

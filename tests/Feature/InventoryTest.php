<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_product_index_and_create_work(): void
    {
        $this->withoutMiddleware();

        $response = $this->get('/products');
        $response->assertOk();

        $response = $this->post('/products', [
            'name' => 'Mouse',
            'quantity' => 10,
            'buy_price' => 250,
            'sell_price' => 400,
            'description' => 'Gaming mouse',
            'status' => 1,
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', ['quantity' => 10]);
        $this->assertDatabaseHas('products', [
            'sku' => Product::latest()->first()->sku,
        ]);
        $this->assertMatchesRegularExpression('/^INV-\d{4}-\d{4}$/', Product::latest()->first()->sku);
    }

    public function test_inventory_generates_unique_financial_year_sku(): void
    {
        $prefix = Product::financialYearPrefix();

        $firstSku = Product::generateSku();
        $this->assertMatchesRegularExpression('/^' . preg_quote($prefix, '/') . '-\d{4}$/', $firstSku);

        Product::create([
            'name' => 'Keyboard',
            'sku' => $firstSku,
            'buy_price' => 200,
            'sell_price' => 350,
            'quantity' => 5,
            'status' => 1,
        ]);

        $secondSku = Product::generateSku();
        $this->assertNotSame($firstSku, $secondSku);
        $this->assertStringStartsWith($prefix, $secondSku);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_purchase()
    {

        Http::fake([
            "localhost:3001/*" => Http::response([
                "id" => "abc123",
                "status" => "success"
            ], 200)
        ]);

        $product = Product::factory()->create([
            "amount" => 1000
        ]);

        $response = $this->postJson("/api/purchase", [

            "name" => "Tester",
            "email" => "tester@email.com",
            "cardNumber" => "5569000000006063",
            "cvv" => "010",

            "products" => [
                [
                    "id" => $product->id,
                    "quantity" => 2
                ]
            ]

        ]);

        $response->assertStatus(200);
    }
}

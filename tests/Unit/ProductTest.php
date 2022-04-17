<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * This function is to Add a product
     */
    public function test_create_products()
    {
        // Register a user
        $user = User::factory()->create();

        // Act like created user
        $this->actingAs($user);

        // Create a product
        $product = Product::factory()->create();

        //verify if data inserted is correct
        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'category' => $product->category,
            'description' => $product->description,
        ]);
    }

    /**
     * This function is to delete a product
     */
    public function test_count_products()
    {
        // Register a user
        $user = User::factory()->create();

        // Act like created user
        $this->actingAs($user);

       // Create a product
       $product = Product::factory()->create();

       $this->assertDatabaseCount('products', 1);
    }

    /**
     * This function is to delete a product
     */
    public function test_delete_products()
    {
        $prod = Product::factory()->create();

        // Get first entry in users
        $prod = Product::first();

        //delete user if not empty
        if($prod){
            $prod->delete();
            $this->assertDeleted($prod);
        }

        
    }
}

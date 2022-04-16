<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This function is to test Login Page
     */
    public function test_login_page()
    {
        // Go to register page
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    /**
     * This function is to test Registration Page
     */
    public function test_register_page()
    {
        // Go to register page
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * This function is to test video link page
     */
    public function test_video_link_page()
    {
        // Register a user
        $user = User::factory()->create();

        // Act like created user
        $this->actingAs($user);

        $listProd = $this->get('/video');
        $listProd->assertStatus(200);
    }

    /**
     * This function is to test dashboard page
     */
    public function test_dashboard_page()
    {
        // Register a user
        $user = User::factory()->create();

        // Act like created user
        $this->actingAs($user);

        $listProd = $this->get('/home');
        $listProd->assertStatus(200);
    }

    /**
     * This function is to test list of products page
     */
    public function test_products_page()
    {
        // Register a user
        $user = User::factory()->create();

        // Act like created user
        $this->actingAs($user);

        $listProd = $this->get('/list');
        $listProd->assertStatus(200);
    }

    /**
     * This function is to test list of products category
     */
    public function test_products_category()
    {
        $catProd = $this->get('/api/category');
        $catProd->assertStatus(200);
    }

    /**
     * This function is to test list of products page
     */
    public function test_products()
    {
        $prod = $this->get('/api/product');
        $prod->assertStatus(200);
    }
}

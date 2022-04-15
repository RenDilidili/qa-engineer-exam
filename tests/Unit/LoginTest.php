<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * This fumction is to test Registration Page
     */
    public function test_register_page()
    {
        // Go to register page
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * This fumction is to Register an account
     */
    public function test_register_account()
    {
        // Register a user
        $user = User::factory()->create();

        //verify if data inserted is correct
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'username' => $user->username,
        ]);
    }

    /**
     * This fumction is to Reset Password
     */
    public function test_password_reset()
    {
        // Register a user
        $user = User::factory()->create();

        // Act like created user
        $this->actingAs($user);

        // Reset a password
        $response = $this->post('/password/reset',[
            'email' => $user['email']
        ]);

        $response->assertStatus($response->status(), 302);
    }
    
    /**
     * This fumction is to Add a product
     */
    public function test_create_products()
    {
        // Register a user
        $user = User::factory()->create();

        // Act like created user
        $this->actingAs($user);

        // Random Numbers
        $randomNum = rand();

        // Create a product
        $prodResponse = $this->post('/product', [
            'name' => 'Test Product '.$randomNum,
            'category' => 'Books',
            'description' => 'This book is for testing purposes '.$randomNum,
            'datetime' => date('Y-m-d H:i:s')
        ]);

        //verify if product is saved
        $prodResponse->assertStatus(200);

        //verify if data inserted is correct
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product '.$randomNum,
            'category' => 'Books',
            'description' => 'This book is for testing purposes '.$randomNum,
        ]);
    }

    /**
     * This fumction is to test list of products page
     */
    public function test_list_products()
    {
        // Register a user
        $user = User::factory()->create();

        // Act like created user
        $this->actingAs($user);

        $listProd = $this->get('/list');
        $listProd->assertStatus(200);
    }

    /**
     * This fumction is to test video link page
     */
    public function test_video_link()
    {
        // Register a user
        $user = User::factory()->create();

        // Act like created user
        $this->actingAs($user);

        $listProd = $this->get('/video');
        $listProd->assertStatus(200);
    }

    /**
     * This fumction is to test dashboard page
     */
    public function test_dashboard()
    {
        // Register a user
        $user = User::factory()->create();

        // Act like created user
        $this->actingAs($user);

        $listProd = $this->get('/home');
        $listProd->assertStatus(200);
    }
}

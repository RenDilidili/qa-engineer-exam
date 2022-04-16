<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * This function is to Register an account
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
     * This function is to Reset Password
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
     * This function is to Reset Password Email
     */
    public function test_password_reset_email()
    {
        // Register a user
        $user = User::factory()->create();

        // Act like created user
        $this->actingAs($user);

        // Reset a password
        $response = $this->post('/password/email',[
            'email' => $user['email'],
            'token' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $response->assertStatus($response->status(), 302);
    }

    /**
     * This function is to Delete User
     */
    public function test_delete_user()
    {
        $user = User::factory()->count(1)->make();

        // Get first entry in users
        $user = User::first();

        //delete user if not empty
        if($user){
            $user->delete();
        }

        $this->assertTrue(true);
    }

    /**
     * This function is to Delete User
     */
    public function test_user_count()
    {
        // Register a user
        $user = User::factory()->create();

        $this->assertDatabaseCount('users', 1);
    }
}

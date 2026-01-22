<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\SamarthUser;

class PasswordRecoveryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create test user
        SamarthUser::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('oldpassword'),
            'role' => 'user',
            'status' => 'active',
        ]);
    }

    /** @test */
    public function password_recovery_page_loads_successfully()
    {
        $response = $this->get('/password/recovery');
        $response->assertStatus(200);
        $response->assertSee('खाता रिकवरी');
    }

    /** @test */
    public function user_can_submit_username_for_password_recovery()
    {
        $response = $this->post('/password/security/check', [
            'username' => 'testuser'
        ]);

        $response->assertRedirect('/password/recovery');
        $response->assertSessionHas('security_question');
    }

    /** @test */
    public function invalid_username_shows_error()
    {
        $response = $this->post('/password/security/check', [
            'username' => 'nonexistent'
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('username');
    }

    /** @test */
    public function password_reset_requires_valid_session()
    {
        $response = $this->post('/password/security/reset', [
            'username' => 'testuser',
            'security_answer' => 'answer',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword'
        ]);

        // Should redirect back without valid session (security question not answered)
        $response->assertRedirect();
    }

    /** @test */
    public function login_page_loads_successfully()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    /** @test */
    public function home_page_redirects_to_login_when_not_authenticated()
    {
        $response = $this->get('/home');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function register_page_loads_successfully()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register');
    }
}


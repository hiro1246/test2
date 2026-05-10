<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_displayed(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('ログイン');
    }

    public function test_setup_route_redirects_to_login_page(): void
    {
        $response = $this->get('/setup');

        $response->assertRedirect('/login');
    }

    public function test_after_setup_transition_login_page_shows_required_elements(): void
    {
        $response = $this->followingRedirects()->get('/setup');

        $response->assertOk();
        $response->assertSee('ログイン');
        $response->assertSee('メールアドレス');
        $response->assertSee('パスワード');
        $response->assertSee('ログインする');
    }

    public function test_authenticated_user_can_transition_from_setup_to_login_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->followingRedirects()->get('/setup');

        $response->assertOk();
        $response->assertSee('ログイン');
        $this->assertGuest();
    }

    public function test_authenticated_user_is_redirected_from_login_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/products');
    }

    public function test_authenticated_user_can_log_out(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_profile_setup_page_shows_logout_button(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/profile/setup');

        $response->assertOk();
        $response->assertSee('ログアウト');
    }

    public function test_email_is_required_with_custom_message(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    public function test_invalid_credentials_show_custom_message(): void
    {
        $user = User::factory()->create([
            'email' => 'taro@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
        $this->assertGuest();
    }

    public function test_verified_user_can_log_in(): void
    {
        $user = User::factory()->create([
            'email' => 'verified@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/products');
        $this->assertAuthenticatedAs($user);
    }

    public function test_unverified_user_is_redirected_to_profile_setup_after_login(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email' => 'unverified@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => null,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/products');
        $this->assertAuthenticatedAs($user);
    }

    public function test_unverified_user_can_view_profile_setup(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/profile/setup');

        $response->assertOk();
        $response->assertSee('プロフィール設定');
        $response->assertSee('COACHTECH');
    }

    public function test_user_can_log_in_with_uppercase_and_spaces_in_email(): void
    {
        $user = User::factory()->create([
            'email' => 'normalize@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => '  NORMALIZE@EXAMPLE.COM  ',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/products');
        $this->assertAuthenticatedAs($user);
    }
}

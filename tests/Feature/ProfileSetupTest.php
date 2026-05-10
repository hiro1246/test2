<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileSetupTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_setup_page_shows_new_profile_fields(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/profile/setup');

        $response->assertOk();
        $response->assertSee('プロフィール画像');
        $response->assertSee('ユーザー名');
        $response->assertSee('郵便番号');
        $response->assertSee('住所');
        $response->assertSee('建物名');
    }

    public function test_authenticated_user_can_upload_profile_image(): void
    {
        Storage::fake('public');

        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->post('/profile/setup', [
            'name' => '画像設定ユーザー',
            'profile_image' => UploadedFile::fake()->image('avatar.png'),
            'postal_code' => '1500001',
            'address' => '東京都渋谷区神宮前1-1-1',
            'building_name' => 'テストビル 101',
        ]);

        $response->assertRedirect('/profile');

        $user->refresh();

        $this->assertNotNull($user->profile_image_path);
        $this->assertTrue(Storage::disk('public')->exists($user->profile_image_path));
    }

    public function test_authenticated_user_can_update_profile_setup_fields(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => '更新前ユーザー',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->post('/profile/setup', [
            'name' => '更新後ユーザー',
            'postal_code' => '1500001',
            'address' => '東京都渋谷区神宮前1-1-1',
            'building_name' => 'テストビル 101',
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHas('status', 'プロフィールを更新しました。');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '更新後ユーザー',
            'postal_code' => '150-0001',
            'address' => '東京都渋谷区神宮前1-1-1',
            'building_name' => 'テストビル 101',
        ]);
    }

    public function test_postal_code_is_required_with_custom_message(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/profile/setup')
            ->post('/profile/setup', [
                'name' => '更新後ユーザー',
                'postal_code' => '',
                'address' => '東京都渋谷区神宮前1-1-1',
                'building_name' => 'テストビル 101',
            ]);

        $response->assertRedirect('/profile/setup');
        $response->assertSessionHasErrors([
            'postal_code' => '郵便番号を入力してください',
        ]);
    }

    public function test_name_is_required_with_custom_message(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/profile/setup')
            ->post('/profile/setup', [
                'name' => '',
                'postal_code' => '1500001',
                'address' => '東京都渋谷区神宮前1-1-1',
                'building_name' => 'テストビル 101',
            ]);

        $response->assertRedirect('/profile/setup');
        $response->assertSessionHasErrors([
            'name' => 'ユーザー名を入力してください',
        ]);
    }

    public function test_address_is_required_with_custom_message(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/profile/setup')
            ->post('/profile/setup', [
                'name' => '更新後ユーザー',
                'postal_code' => '1500001',
                'address' => '',
                'building_name' => 'テストビル 101',
            ]);

        $response->assertRedirect('/profile/setup');
        $response->assertSessionHasErrors([
            'address' => '住所を入力してください',
        ]);
    }

    public function test_postal_code_must_be_valid_format_with_custom_message(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/profile/setup')
            ->post('/profile/setup', [
                'name' => '更新後ユーザー',
                'postal_code' => '150-000',
                'address' => '東京都渋谷区神宮前1-1-1',
                'building_name' => 'テストビル 101',
            ]);

        $response->assertRedirect('/profile/setup');
        $response->assertSessionHasErrors([
            'postal_code' => '郵便番号は123-4567形式で入力してください',
        ]);
    }

    public function test_building_name_must_be_within_max_length_with_custom_message(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $longBuildingName = str_repeat('あ', 256);

        $response = $this->actingAs($user)
            ->from('/profile/setup')
            ->post('/profile/setup', [
                'name' => '更新後ユーザー',
                'postal_code' => '1500001',
                'address' => '東京都渋谷区神宮前1-1-1',
                'building_name' => $longBuildingName,
            ]);

        $response->assertRedirect('/profile/setup');
        $response->assertSessionHasErrors([
            'building_name' => '建物名は255文字以内で入力してください',
        ]);
    }

    public function test_building_name_is_required_with_custom_message(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/profile/setup')
            ->post('/profile/setup', [
                'name' => '更新後ユーザー',
                'postal_code' => '1500001',
                'address' => '東京都渋谷区神宮前1-1-1',
                'building_name' => '',
            ]);

        $response->assertRedirect('/profile/setup');
        $response->assertSessionHasErrors([
            'building_name' => '建物名を入力してください',
        ]);
    }
}

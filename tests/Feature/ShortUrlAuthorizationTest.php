<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_create_short_urls(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->admin()->for($company)->create();

        $response = $this->actingAs($admin)->post('/short-urls', [
            'original_url' => 'https://example.com',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount('short_urls', 0);
    }

    public function test_member_cannot_create_short_urls(): void
    {
        $company = Company::factory()->create();
        $member = User::factory()->member()->for($company)->create();

        $response = $this->actingAs($member)->post('/short-urls', [
            'original_url' => 'https://example.com',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount('short_urls', 0);
    }

    public function test_super_admin_cannot_create_short_urls(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $response = $this->actingAs($superAdmin)->post('/short-urls', [
            'original_url' => 'https://example.com',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount('short_urls', 0);
    }

     

     

    public function test_super_admin_cannot_view_the_short_url_list(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $response = $this->actingAs($superAdmin)->get('/short-urls');

        $response->assertForbidden();
    }

    
}

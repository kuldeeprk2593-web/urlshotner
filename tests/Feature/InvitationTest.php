<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_cannot_invite_an_admin_into_a_brand_new_company(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $response = $this->actingAs($superAdmin)->post('/invitations', [
            'name' => 'New Admin',
            'email' => 'new-admin@example.com',
            'new_company_name' => 'Brand New Co',
            'role' => 'admin',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertDatabaseMissing('users', ['email' => 'new-admin@example.com']);
        $this->assertDatabaseMissing('companies', ['name' => 'Brand New Co']);
    }

    public function test_super_admin_can_invite_an_admin_into_an_existing_company(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();
        $company = Company::factory()->create();

        $response = $this->actingAs($superAdmin)->post('/invitations', [
            'name' => 'New Admin',
            'email' => 'new-admin@example.com',
            'company_id' => $company->id,
            'role' => 'admin',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'new-admin@example.com',
            'role' => 'admin',
            'company_id' => $company->id,
        ]);
    }

    public function test_admin_cannot_invite_another_admin_or_a_member(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->admin()->for($company)->create();

        $this->actingAs($admin)->post('/invitations', [
            'name' => 'Another Admin',
            'email' => 'another-admin@example.com',
            'role' => 'admin',
        ])->assertSessionHasErrors('role');

        $this->actingAs($admin)->post('/invitations', [
            'name' => 'A Member',
            'email' => 'a-member@example.com',
            'role' => 'member',
        ])->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('users', ['email' => 'another-admin@example.com']);
        $this->assertDatabaseMissing('users', ['email' => 'a-member@example.com']);
    }

     
}

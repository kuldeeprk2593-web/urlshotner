<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Optional convenience seeder (NOT part of the raw-SQL requirement) that
 * creates one demo company with a user for every company-scoped role so
 * the app can be clicked through manually right after `migrate --seed`.
 *
 * All demo users share the password: "password"
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::firstOrCreate(['name' => 'Acme Inc']);

        $users = [
            ['name' => 'Admin', 'email' => 'admin@sembark.com', 'role' => UserRole::Admin],
            ['name' => 'Member', 'email' => 'member@sembark.com', 'role' => UserRole::Member] 
        ];

        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => $data['role'],
                    'company_id' => $company->id,
                ]
            );
        }
    }
}

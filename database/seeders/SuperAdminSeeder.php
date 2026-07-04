<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Creates the initial SuperAdmin account using a raw SQL INSERT, as
 * explicitly required by the assignment brief ("Create a SuperAdmin
 * account using a Database Seeder using raw SQL").
 */
class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'superadmin@sembark.com';

        $exists = DB::selectOne('select id from users where email = ?', [$email]);

        if ($exists) {
            return;
        }

        $hashedPassword = Hash::make('password');
        $now = now()->toDateTimeString();

        DB::insert(
            'insert into users (name, email, password, role, company_id, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?)',
            ['Super Admin', $email, $hashedPassword, 'super_admin', null, $now, $now]
        );
    }
}

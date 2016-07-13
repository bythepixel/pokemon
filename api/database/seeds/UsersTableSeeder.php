<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => password_hash('secret', PASSWORD_BCRYPT),
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'firstname' => 'علی',
            'lastname' => 'قاسمی',
            'phoneNumber' => '09195884064',
            'role' => 'superAdmin',
            'password' => bcrypt(12345678),
        ]);
    }
}

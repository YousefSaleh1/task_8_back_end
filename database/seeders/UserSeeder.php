<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            User::create([
                'name'     => 'Owner',
                'email'    => 'owner@gmail.com',
                'password' => 'owner1234'
            ]);

            $this->command->info('User seeded successfully.');
        } catch (\Throwable $th) {
            Log::error($th);
            $this->command->info('User dide=n\'t seeded.');
        }
    }
}

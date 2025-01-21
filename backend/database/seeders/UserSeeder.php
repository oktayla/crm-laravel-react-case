<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Administrator
        $admin = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('administrator');

        // Create Sales Manager
        $salesManager = User::factory()->create([
            'name' => 'Sales Manager',
            'email' => 'sales.manager@example.com',
        ]);

        $salesManager->assignRole('sales-manager');

        // Create Sales Staff
        User::factory()->count(3)->create()->each(function ($user) {
            $user->assignRole('sales-staff');
        });

        // Create Customer Service Representatives
        User::factory()->count(2)->create()->each(function ($user) {
            $user->assignRole('customer-service');
        });
    }
}

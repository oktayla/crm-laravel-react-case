<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',

            'view orders',
            'create orders',
            'edit orders',
            'delete orders',
            'process orders',
            'cancel orders',
            'view invoices',
            'create invoices',

            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Administrator Role
        $admin = Role::create(['name' => 'administrator']);
        $admin->givePermissionTo(Permission::all());

        // Sales Manager Role
        $salesManager = Role::create(['name' => 'sales-manager']);
        $salesManager->givePermissionTo([
            'view customers', 'create customers', 'edit customers',
            'view orders', 'create orders', 'edit orders', 'process orders', 'cancel orders',
            'view invoices', 'create invoices',
            'view users'
        ]);

        // Sales Staff Role
        $salesStaff = Role::create(['name' => 'sales-staff']);
        $salesStaff->givePermissionTo([
            'view customers', 'create customers', 'edit customers',
            'view orders', 'create orders', 'edit orders',
            'view invoices', 'create invoices'
        ]);

        // Customer Service Role
        $customerService = Role::create(['name' => 'customer-service']);
        $customerService->givePermissionTo([
            'view customers', 'edit customers',
            'view orders',
            'view invoices'
        ]);
    }
}

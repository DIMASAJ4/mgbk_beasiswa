<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage-users',
            'manage-roles',
            'manage-scholarships',
            'apply-scholarship',
            'verify-applications',
            'view-dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // Create roles and assign existing permissions

        // Admin: all permissions
        $adminRole = Role::findOrCreate('Admin', 'web');
        $adminRole->givePermissionTo(Permission::all());

        // Guru BK: verify applications, view dashboard, manage scholarships
        $guruBkRole = Role::findOrCreate('Guru BK', 'web');
        $guruBkRole->givePermissionTo([
            'verify-applications',
            'view-dashboard',
            'manage-scholarships',
        ]);

        // Siswa: apply scholarship, view dashboard
        $siswaRole = Role::findOrCreate('Siswa', 'web');
        $siswaRole->givePermissionTo([
            'apply-scholarship',
            'view-dashboard',
        ]);
    }
}

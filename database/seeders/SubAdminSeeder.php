<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SubAdminSeeder extends Seeder
{
    public function run()
    {
        // Create sub-admin role if it doesn't exist
        $subAdminRole = Role::firstOrCreate([
            'name' => 'sub-admin',
            'guard_name' => 'web'
        ]);

        // Assign specific permissions to sub-admin 
        $subAdminPermissions = [
            'view tours',
            'create tours',
            'edit tours',
            'view bookings',
            'create bookings',
            'edit bookings',
        ];

        foreach ($subAdminPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($permission && !$subAdminRole->hasPermissionTo($permission)) {
                $subAdminRole->givePermissionTo($permission);
            }
        }

        // Create or find sub-admin user
        $subAdmin = User::firstOrCreate(
            ['email' => 'subadmin@eotour.com'],
            [
                'name' => 'Sub Admin User',
                'password' => bcrypt('password'),
                'phone' => '1234567891',
                'address' => 'Sub Admin Address'
            ]
        );

        // Assign sub-admin role to user
        $subAdmin->assignRole($subAdminRole);

        // Also, let's create another regular user for testing
        $user2 = User::firstOrCreate(
            ['email' => 'user2@eotour.com'],
            [
                'name' => 'User Two',
                'password' => bcrypt('password'),
                'phone' => '0987654322',
                'address' => 'User Two Address'
            ]
        );
        
        $userRole = Role::where('name', 'user')->first();
        if ($userRole && !$user2->hasRole('user')) {
            $user2->assignRole($userRole);
        }

        echo "Sub-admin created: subadmin@eotour.com / password\n";
        echo "Permissions: Can manage tours and bookings (view, create, edit only)\n";
        echo "\n";
        echo "User Two created: user2@eotour.com / password\n";
        echo "Role: Regular user\n";
    }
}
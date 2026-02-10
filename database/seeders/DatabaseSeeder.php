<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tour;
use App\Models\Booking;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'view tours',
            'create tours',
            'edit tours',
            'delete tours',
            'view bookings',
            'create bookings',
            'edit bookings',
            'delete bookings',
            'manage users',
            'manage roles',
            'manage permissions'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);

        // Assign all permissions to admin
        $adminRole->syncPermissions(Permission::all());

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@eotour.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'address' => 'Admin Address'
        ]);
        $admin->assignRole('admin');

        // Create regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@eotour.com',
            'password' => bcrypt('password'),
            'phone' => '0987654321',
            'address' => 'User Address'
        ]);
        $user->assignRole('user');

        // Create sample tours
        $tours = [
            [
                'name' => 'Bali Paradise Tour',
                'description' => 'Experience the beauty of Bali with our 7-day luxury tour package. Visit temples, beaches, and cultural sites.',
                'price' => 1500.00,
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(37),
                'status' => 'active',
                'image' => null
            ],
            [
                'name' => 'Japanese Adventure',
                'description' => 'Explore Tokyo, Kyoto, and Osaka in this 10-day cultural journey through Japan.',
                'price' => 2500.00,
                'start_date' => now()->addDays(45),
                'end_date' => now()->addDays(55),
                'status' => 'active',
                'image' => null
            ],
            [
                'name' => 'European Discovery',
                'description' => '14-day tour covering Paris, Rome, and Barcelona. Perfect for first-time Europe visitors.',
                'price' => 3500.00,
                'start_date' => now()->addDays(60),
                'end_date' => now()->addDays(74),
                'status' => 'active',
                'image' => null
            ]
        ];

        foreach ($tours as $tourData) {
            Tour::create($tourData);
        }

        // Create sample bookings
        $bookings = [
            [
                'tour_id' => 1,
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'people_count' => 2,
                'total_price' => 3000.00,
                'status' => 'confirmed',
                'special_requests' => 'Vegetarian meals required'
            ],
            [
                'tour_id' => 2,
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'people_count' => 1,
                'total_price' => 2500.00,
                'status' => 'pending',
                'special_requests' => null
            ]
        ];

        foreach ($bookings as $bookingData) {
            Booking::create($bookingData);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\UserCredit;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'Admin', 'slug' => 'admin']);
        $userRole = Role::create(['name' => 'User', 'slug' => 'user']);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id
        ]);

        // Create some regular users with credits
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
                'credits' => 100
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
                'credits' => 150
            ]
        ];

        foreach ($users as $userData) {
            $initialCredits = $userData['credits'];
            
            $user = User::create($userData);
            
            // Create user credits and initial transaction
            $userCredit = UserCredit::create([
                'user_id' => $user->id,
                'balance' => $initialCredits
            ]);

            // Create initial credit transaction
            $user->creditTransactions()->create([
                'amount' => $initialCredits,
                'type' => 'credit',
                'description' => 'Initial credit balance',
                'balance_after' => $initialCredits
            ]);

            // Create a sample subscription
            Subscription::create([
                'user_id' => $user->id,
                'plan' => 'Basic Plan',
                'start_date' => now(),
                'end_date' => now()->addMonths(1),
                'status' => 'active'
            ]);
        }
    }
}

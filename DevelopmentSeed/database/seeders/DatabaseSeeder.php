<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Habit;
use App\Models\Quest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@levelup.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'level' => 10,
            'xp' => 750,
            'total_xp' => 4500,
            'current_streak' => 15,
            'longest_streak' => 30,
            'rank_title' => 'Dungeon Master',
        ]);

        // Create Demo User
        $user = User::create([
            'name' => 'Demo Player',
            'email' => 'demo@levelup.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'level' => 5,
            'xp' => 320,
            'total_xp' => 1820,
            'current_streak' => 7,
            'longest_streak' => 14,
            'rank_title' => 'Apprentice',
        ]);

        // Create additional users
        $users = [
            ['name' => 'Sarah Connor', 'email' => 'sarah@example.com', 'level' => 8, 'total_xp' => 3200],
            ['name' => 'John Smith', 'email' => 'john@example.com', 'level' => 3, 'total_xp' => 850],
            ['name' => 'Emma Wilson', 'email' => 'emma@example.com', 'level' => 12, 'total_xp' => 5800],
            ['name' => 'Mike Johnson', 'email' => 'mike@example.com', 'level' => 6, 'total_xp' => 2400],
            ['name' => 'Lisa Brown', 'email' => 'lisa@example.com', 'level' => 4, 'total_xp' => 1200],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'role' => 'user',
                'level' => $userData['level'],
                'xp' => rand(0, $userData['level'] * 100),
                'total_xp' => $userData['total_xp'],
                'current_streak' => rand(0, 20),
                'longest_streak' => rand(5, 30),
            ]);
        }

        // Create Habits for Demo User
        $habits = [
            ['title' => 'Morning Meditation', 'icon' => '🧘', 'description' => 'Start the day with 10 minutes of mindfulness', 'difficulty' => 'easy', 'xp_reward' => 15, 'current_streak' => 7],
            ['title' => 'Exercise', 'icon' => '💪', 'description' => '30 minutes of physical activity', 'difficulty' => 'medium', 'xp_reward' => 25, 'current_streak' => 5],
            ['title' => 'Read 20 Pages', 'icon' => '📚', 'description' => 'Expand your knowledge daily', 'difficulty' => 'easy', 'xp_reward' => 20, 'current_streak' => 12],
            ['title' => 'Drink 8 Glasses Water', 'icon' => '💧', 'description' => 'Stay hydrated throughout the day', 'difficulty' => 'easy', 'xp_reward' => 10, 'current_streak' => 3],
            ['title' => 'Code for 2 Hours', 'icon' => '💻', 'description' => 'Practice programming skills', 'difficulty' => 'hard', 'xp_reward' => 40, 'current_streak' => 8],
            ['title' => 'No Social Media', 'icon' => '📵', 'description' => 'Digital detox challenge', 'difficulty' => 'hard', 'xp_reward' => 35, 'current_streak' => 2],
        ];

        foreach ($habits as $habitData) {
            Habit::create([
                'user_id' => $user->id,
                'title' => $habitData['title'],
                'icon' => $habitData['icon'],
                'description' => $habitData['description'],
                'difficulty' => $habitData['difficulty'],
                'xp_reward' => $habitData['xp_reward'],
                'frequency' => 'daily',
                'current_streak' => $habitData['current_streak'],
                'longest_streak' => $habitData['current_streak'] + rand(0, 10),
                'times_completed' => $habitData['current_streak'] + rand(10, 50),
            ]);
        }

        // Create Quests for Demo User
        $quests = [
            ['title' => 'Complete 5 Habits Today', 'type' => 'daily', 'description' => 'Finish at least 5 habits in a single day', 'xp_reward' => 50, 'target' => 5, 'progress' => 3, 'status' => 'active'],
            ['title' => 'Read a Book', 'type' => 'weekly', 'description' => 'Complete reading an entire book this week', 'xp_reward' => 150, 'target' => 1, 'progress' => 0, 'status' => 'active'],
            ['title' => 'Workout Warrior', 'type' => 'weekly', 'description' => 'Complete 5 workout sessions this week', 'xp_reward' => 200, 'target' => 5, 'progress' => 2, 'status' => 'active'],
            ['title' => '30 Day Meditation Challenge', 'type' => 'boss', 'description' => 'Meditate every day for 30 days straight', 'xp_reward' => 500, 'target' => 30, 'progress' => 15, 'status' => 'active'],
            ['title' => 'Learn New Programming Language', 'type' => 'boss', 'description' => 'Complete a full course on a new language', 'xp_reward' => 750, 'target' => 100, 'progress' => 45, 'status' => 'active'],
            ['title' => 'Morning Routine Master', 'type' => 'daily', 'description' => 'Complete all morning habits', 'xp_reward' => 75, 'target' => 3, 'progress' => 3, 'status' => 'completed'],
        ];

        foreach ($quests as $questData) {
            Quest::create([
                'user_id' => $user->id,
                'title' => $questData['title'],
                'description' => $questData['description'],
                'type' => $questData['type'],
                'xp_reward' => $questData['xp_reward'],
                'target' => $questData['target'],
                'progress' => $questData['progress'],
                'status' => $questData['status'],
                'due_date' => $questData['type'] === 'daily' ? now() : ($questData['type'] === 'weekly' ? now()->addDays(7) : now()->addMonth()),
                'completed_at' => $questData['status'] === 'completed' ? now()->subDay() : null,
            ]);
        }

        // Create some habits for admin too
        Habit::create([
            'user_id' => $admin->id,
            'title' => 'Review User Reports',
            'icon' => '📊',
            'description' => 'Check daily platform analytics',
            'difficulty' => 'medium',
            'xp_reward' => 30,
            'frequency' => 'daily',
            'current_streak' => 15,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Demo Accounts:');
        $this->command->info('  Admin: admin@levelup.com / password');
        $this->command->info('  User:  demo@levelup.com / password');
    }
}

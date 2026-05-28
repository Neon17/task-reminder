<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskUserFollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('id')->toArray();

        Task::all()->each(function ($task) use ($users) {
            // 70% chance the task will have followers
            if (fake()->boolean(70)) {
                // Exclude task creator
                $availableFollowers = array_diff($users, [$task->created_by]);

                // Random 1–3 followers
                $followers = collect($availableFollowers)
                    ->shuffle()
                    ->take(rand(1, min(3, count($availableFollowers))));

                foreach ($followers as $userId) {
                    DB::table('task_user_followers')->insert([
                        'task_id'    => $task->id,
                        'user_id'    => $userId,
                        'permission' => fake()->randomElement(['read', 'write', 'admin']),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            // else: no followers for this task (30% chance)
        });
    }
}

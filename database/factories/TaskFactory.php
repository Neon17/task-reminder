<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $assignedDate = $this->faker->dateTimeBetween('now', '+1 year');
        $assignedCarbon = Carbon::instance($assignedDate);

        // Notification start date (must be before assigned date)
        $notificationStartDate = $this->faker->dateTimeBetween(
            'now', 
            $assignedCarbon->copy()->subDays(1) // At least 1 day before assigned date
        );
        $notificationStartCarbon = Carbon::instance($notificationStartDate);
        $maxInterval = $notificationStartCarbon->diffInDays($assignedCarbon);

        // Generate interval (1 day to max interval days)
        $interval = $this->faker->numberBetween(1, $maxInterval);

        // 30% chance of being completed
        // $completedDate = $this->faker->optional(0.3)->dateTimeBetween(
        //     $notificationStartDate,
        //     $assignedDate
        // );

        return [
            'title' => $this->faker->sentence(1),
            'description' => $this->faker->sentence(3),
            'created_by' => User::factory(),
            'assigned_date' => $assignedDate,
            'notification_start_date' => $notificationStartDate,
            'notification_interval' => $interval, // In days (integer)
            'last_notified_at' => $this->generateLastNotified(
                $notificationStartCarbon,
                $assignedCarbon,
                $interval
            ),
            // 'deleted_at' => $this->faker->optional(0.1)->dateTimeBetween(
            //     $notificationStartDate,
            //     $assignedDate
            // ),
            // 'created_at' => $this->faker->dateTimeBetween('-1 month', $notificationStartDate),
            // 'updated_at' => $this->faker->dateTimeBetween(
            //     $notificationStartDate,
            //     $completedDate ?? $assignedDate
            // ),
        ];
    }

    protected function generateLastNotified($start, $end, $interval)
    {    
        if ($start->diffInDays(now()) > 0){
            // For incomplete tasks, 50% chance of having been notified
            return $this->faker->optional(0.5)->dateTimeBetween(
                $start,
                min($end, now()) // Can't notify in future
            );
        }

        return null;
    }

    // State method for tasks with specific interval
    public function withInterval(int $days)
    {
        return $this->state(function (array $attributes) use ($days) {
            $assigned = Carbon::parse($attributes['assigned_date']);
            $start = Carbon::parse($attributes['notification_start_date']);
            
            // Ensure interval is valid
            $maxInterval = $start->diffInDays($assigned);
            $interval = min($days, $maxInterval);
            
            return [
                'notification_interval' => $interval,
            ];
        });
    }
}

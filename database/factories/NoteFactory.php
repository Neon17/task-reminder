<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $reasons = ['creation', 'updation'];
        $labels = $this->faker->randomElements(
            ['important', 'review', 'bug', 'feature', 'question', 'documentation'],
            $this->faker->numberBetween(0, 3)
        );

        return [
            'title' => $this->faker->optional(0.7)->sentence(3), // 70% chance of having title
            'description' => $this->faker->paragraphs(
                $this->faker->numberBetween(1, 3),
                true
            ),
            'labels' => count($labels) ? $labels : null,
            'user_id' => User::factory(),
            'task_id' => Task::factory(),
            'reason' => $this->faker->randomElement($reasons),
        ];
    }

    // State methods for specific note reasons
    public function creationNote()
    {
        return $this->state(function (array $attributes) {
            return [
                'reason' => 'creation',
                'description' => "Task was created with initial details: " . $this->faker->paragraph(),
            ];
        });
    }

    public function updationNote()
    {
        return $this->state(function (array $attributes) {
            return [
                'reason' => 'updation',
                'description' => "Task was updated: " . $this->faker->paragraph(),
            ];
        });
    }

    public function deletionNote()
    {
        return $this->state(function (array $attributes) {
            return [
                'reason' => 'deletion',
                'description' => "Task was deleted: " . $this->faker->sentence(),
            ];
        });
    }

    public function completionNote()
    {
        return $this->state(function (array $attributes) {
            return [
                'reason' => 'completion',
                'description' => "Task was marked as completed: " . $this->faker->sentence(),
            ];
        });
    }

    // State method for notes with specific labels
    public function withLabels(array $labels)
    {
        return $this->state(function (array $attributes) use ($labels) {
            return [
                'labels' => $labels,
            ];
        });
    }
}

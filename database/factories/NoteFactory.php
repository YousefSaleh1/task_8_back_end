<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    protected $model = Note::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $noteableType = $this->faker->randomElement(['App\Models\Employee', 'App\Models\Department']);
        $noteableId = $this->getNoteableId($noteableType);

        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'noteable_id' => $noteableId,
            'noteable_type' => $noteableType
        ];
    }

    /**
     * Get the noteable ID based on the given noteable type.
     *
     * @param string $noteableType
     * @return int|null
     */
    private function getNoteableId($noteableType)
    {
        if ($noteableType === 'App\Models\Employee') {
            return Employee::factory()->create()->id;
        } elseif ($noteableType === 'App\Models\Department') {
            return Department::factory()->create()->id;
        }

        return null;
    }
}

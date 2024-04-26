<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Note;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $this->call(UserSeeder::class);
            Department::factory()->count(5)->create();
            Employee::factory()->count(5)->create();
            Project::factory()->count(5)->create();
            Note::factory()->count(5)->create();
            
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The employees that belong to the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_project');
    }
}

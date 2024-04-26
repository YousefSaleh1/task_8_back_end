<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'department_id',
        'first_name',
        'last_name',
        'email',
        'position',
    ];

    /**
     * Get the department that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * The projects that belong to the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'employee_project');
    }

    /**
     * Get all of the notes for the employee.
     *
     * This function defines a polymorphic relationship between the employee model and the note model,
     * allowing the employee to have many notes associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    /**
     * Set the first name attribute.
     *
     * This mutator capitalizes the first letter of the first name before assigning it to the "first_name" attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }

    /**
     * Set the last name attribute.
     *
     * This mutator capitalizes the first letter of the first name before assigning it to the "first_name" attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }

    /**
     * Get the full name of the employee.
     *
     * This accessor combines the first name and last name to create the full name of the employee.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}

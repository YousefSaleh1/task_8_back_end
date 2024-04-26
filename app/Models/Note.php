<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'title',
        'body',
        'noteable_id',
        'noteable_type',
    ];

    /**
     * Get the parent model of the polymorphic relationship.
     *
     * This method defines the inverse of a polymorphic relationship, allowing the Note model to retrieve the parent model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function noteable()
    {
        return $this->morphTo();
    }
}

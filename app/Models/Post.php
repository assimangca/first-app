<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // This tells Laravel it's okay to save these fields to the database
    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    /**
     * A post belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
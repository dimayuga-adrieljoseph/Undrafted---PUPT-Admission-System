<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFile extends Model
{
    use HasFactory;

    // Columns that can be filled when creating/updating
    protected $fillable = [
        'user_id',
        'type',
        'file_path',
        'original_name'
    ];

    /**
     * The user who owns this file.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get full URL for the file.
     */
    public function getUrlAttribute()
    {
        return url('storage/' . $this->file_path);
    }
}

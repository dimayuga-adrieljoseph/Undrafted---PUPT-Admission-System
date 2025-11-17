<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Columns that can be filled when creating/updating a user
    protected $fillable = [
        'name',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'password',
        'birthday',
        'sex',
        'contactnumber',
        'address',
        'school',
        'schoolAdd',
        'schoolyear',
        'dateGrad',
        'strand',
        'track'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all uploaded files for this user
     */
    public function files()
    {
        return $this->hasMany(UserFile::class);
    }

    /**
     * Get uploaded file by type
     */
    public function fileByType($type)
    {
        return $this->files()->where('type', $type)->first();
    }
}

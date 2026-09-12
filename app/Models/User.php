<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * This application uses the existing CRM user table rather than Laravel's
     * default users-table column names.
     */
    protected $primaryKey = 'user_id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_name',
        'user_mobile',
        'user_email',
        'user_password',
        'user_photo',
        'user_role',
        'user_token',
    ];

    /**
     * The attributes that should be hidden for arrays and JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_password',
        'user_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_created_at' => 'datetime',
    ];

    public function getAuthPassword(): string
    {
        return $this->user_password;
    }

    public function getAuthPasswordName(): string
    {
        return 'user_password';
    }

    public function getRememberToken(): ?string
    {
        return $this->user_token;
    }

    public function setRememberToken($value): void
    {
        $this->user_token = $value;
    }

    public function getRememberTokenName(): string
    {
        return 'user_token';
    }

    public function getEmailForPasswordReset(): string
    {
        return $this->user_email;
    }

    /**
     * Compatibility accessors for Breeze views and profile code.
     */
    public function getNameAttribute(): ?string
    {
        return $this->user_name;
    }

    public function getEmailAttribute(): ?string
    {
        return $this->user_email;
    }

    public function getPasswordAttribute(): ?string
    {
        return $this->user_password;
    }

    public function getIdAttribute(): ?int
    {
        return $this->user_id;
    }

    public function setNameAttribute(?string $value): void
    {
        $this->attributes['user_name'] = $value;
    }

    public function setEmailAttribute(?string $value): void
    {
        $this->attributes['user_email'] = $value;
    }

    public function setPasswordAttribute(?string $value): void
    {
        $this->attributes['user_password'] = $value;
    }
}

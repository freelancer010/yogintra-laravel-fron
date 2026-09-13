<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    private static ?bool $usesLegacyColumns = null;

    /**
     * The local development database uses CRM-style user columns, while the
     * hosted frontend uses Laravel's default columns. Support both safely.
     */
    public static function usesLegacyColumns(): bool
    {
        return self::$usesLegacyColumns ??= Schema::hasColumn('users', 'user_email');
    }

    public static function emailColumn(): string
    {
        return self::usesLegacyColumns() ? 'user_email' : 'email';
    }

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
        'user_email',
        'user_password',
        'user_token',
        'user_photo',
        'user_role',
    ];

    /**
     * The attributes that should be hidden for arrays and JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'user_password',
        'user_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getKeyName(): string
    {
        return self::usesLegacyColumns() ? 'user_id' : parent::getKeyName();
    }

    public function usesTimestamps(): bool
    {
        return ! self::usesLegacyColumns();
    }

    public function getAuthPassword(): string
    {
        return (string) (self::usesLegacyColumns()
            ? ($this->attributes['user_password'] ?? '')
            : ($this->attributes['password'] ?? ''));
    }

    public function getAuthPasswordName(): string
    {
        return self::usesLegacyColumns() ? 'user_password' : 'password';
    }

    public function getRememberToken(): ?string
    {
        return self::usesLegacyColumns()
            ? ($this->attributes['user_token'] ?? null)
            : ($this->attributes['remember_token'] ?? null);
    }

    public function setRememberToken($value): void
    {
        $this->attributes[self::usesLegacyColumns() ? 'user_token' : 'remember_token'] = $value;
    }

    public function getRememberTokenName(): string
    {
        return self::usesLegacyColumns() ? 'user_token' : 'remember_token';
    }

    public function getEmailForPasswordReset(): string
    {
        return (string) $this->email;
    }

    public function getNameAttribute(): ?string
    {
        return self::usesLegacyColumns()
            ? ($this->attributes['user_name'] ?? null)
            : ($this->attributes['name'] ?? null);
    }

    public function setNameAttribute(?string $value): void
    {
        $this->attributes[self::usesLegacyColumns() ? 'user_name' : 'name'] = $value;
    }

    public function getEmailAttribute(): ?string
    {
        return self::usesLegacyColumns()
            ? ($this->attributes['user_email'] ?? null)
            : ($this->attributes['email'] ?? null);
    }

    public function setEmailAttribute(?string $value): void
    {
        $this->attributes[self::emailColumn()] = $value;
    }

    public function getPasswordAttribute(): ?string
    {
        return self::usesLegacyColumns()
            ? ($this->attributes['user_password'] ?? null)
            : ($this->attributes['password'] ?? null);
    }

    public function setPasswordAttribute(?string $value): void
    {
        $this->attributes[self::getAuthPasswordName()] = $value;
    }
}

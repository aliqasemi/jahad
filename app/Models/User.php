<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'phoneNumber',
        'address',
        'email',
        'role',
        'password',
        'confirm'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $mapMessageFields = [
        'user_firstname' => ':firstname',
        'user_lastname' => ':lastname',
        'confirm_code' => '!confirm_code',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superAdmin';
    }

    public function isAccess(string $role): bool
    {
        return $this->role === $role;
    }

    public function verify(): static
    {
        $this->phone_verified_at = Carbon::now();
        return $this;
    }

    public function isVerify(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    public function steps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Step::class);
    }

    public function templates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Template::class);
    }
}

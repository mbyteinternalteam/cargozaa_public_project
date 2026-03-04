<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'email_verified_at',
        'user_type',
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
            'deleted' => 'datetime',
            'user_type' => UserType::class,
            'status' => UserStatus::class,
        ];
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function owner()
    {
        return $this->hasOne(Owner::class);
    }

    // ! Move to Public Project

    /**
     * Scope to filter by user type
     */
    public function scopeOfType($query, UserType $type)
    {
        return $query->where('user_type', $type);
    }

    /**
     * Scope to get only customers
     */
    public function scopeCustomers($query)
    {
        return $query->where('user_type', UserType::CUSTOMER);
    }

    /**
     * Scope to get only owners
     */
    public function scopeOwners($query)
    {
        return $query->where('user_type', UserType::OWNER);
    }

    /**
     * Scope to get only public users
     */
    public function scopePublicUsers($query)
    {
        return $query->whereIn('user_type', [UserType::CUSTOMER, UserType::OWNER]);
    }

    /**
     * Get redirect route after login
     */
    public function getRedirectRoute(): string
    {
        return $this->user_type->defaultRedirectRoute();
    }
}

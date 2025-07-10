<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

/**
 * User Model
 *
 * This model represents the users of the application. It extends Laravel's built-in
 * Authenticatable class to support authentication, and includes traits for roles,
 * soft deletes, notifications, and factory usage.
 */
class User extends Authenticatable
{
    /**
     * Enables use of model factories for testing/seeding,
     * notification sending (e.g. emails, in-app),
     * and soft deletes — users are not removed from DB
     *
     * @use HasFactory<\Database\Factories\UserFactory>
     */
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that can be mass assigned.
     *
     * These are the fields you can safely fill using `create()` or `update()`.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'force_password_change',
    ];

    /**
     * The attributes that should be hidden when the model is converted to arrays or JSON.
     *
     * Useful for API responses and serialization security.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts applied to model attributes.
     *
     * Used to auto-convert or format values.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}

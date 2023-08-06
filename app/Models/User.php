<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function cartItems()
    {
        return $this->belongsToMany(Item::class, 'carts')
            ->using(Cart::class)->withPivot(
                'cookie_id',
                'id',
                'quantity'
            )->as('cart');
    }

    public function messages()
    {
        return $this->hasMany(Massage::class);
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function ownsRestaurant($restaurant_id)
    {
        // Check if the user has a related restaurant with the given restaurant_id
        return $this->restaurants()->where('id', $restaurant_id)->exists();
    }
}

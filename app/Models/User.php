<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserBalance;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
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

    public function projects()
    {
        return $this->hasMany(Project::class, 'creator_id');
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class, 'user_id');
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function jobAdvertisements()
    {
        return $this->hasMany(JobAdvertisement::class, 'creator_id');
    }

    public function portfolios()
    {
        return $this->hasMany(JobAdvertisementPortfolio::class);
    }

    public function balance()
    {
        return $this->hasOne(UserBalance::class);
    }

    public function ordersAsClient()
    {
        return $this->hasMany(Order::class, 'client_id');
    }
    
    public function ordersAsFreelancer()
    {
        return $this->hasMany(Order::class, 'freelancer_id');
    }

    protected static function booted()
    {
        static::created(function ($user) {
            UserBalance::create([
                'user_id' => $user->id,
                'amount' => 0,
            ]);
        });
    }


}

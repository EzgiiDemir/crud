<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture_url',
        'theme',
        'notifications'
    ];

    /**
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
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

public function setProfilePicture($image)
{

    $imageName = time() . '.' . $image->extension();
    $image->move(public_path('images'), $imageName);
    $this->profile_picture = $imageName;
    $this->save();
}
public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }
}

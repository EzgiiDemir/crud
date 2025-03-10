<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'quantity',
        'price',
        'description',
        'user_id', // kullanıcı ile ilişki için user_id eklenmeli
    ];

    /**
     * Product modelindeki kullanıcıya ait ilişki
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

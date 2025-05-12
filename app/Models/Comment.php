<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content'];

    // Kullanıcı ile ilişki
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Ürün ile ilişki
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

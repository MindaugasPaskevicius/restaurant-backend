<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'dish_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function dish() {
        return $this->belongsTo(Dish::class);
    }
}

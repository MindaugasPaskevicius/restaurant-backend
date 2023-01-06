<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'image',
        'restourant_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function restourant()
    {
        return $this->belongsTo(Restourant::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}

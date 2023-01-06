<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restourant extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'city',
        'address',
        'hours',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function dishes() {
        return $this->hasMany(Dish::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use  HasFactory;


    protected $fillable =
    [
        'name',
        'is_active',
    ];

    public function interview()
    {
        return $this->hasMany(Interview::class , 'category_id');
    }
}

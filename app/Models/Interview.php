<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;


    protected $fillable =
    [
        'slug',
        'title',
        'description',
        'category_id',
        'level',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id');
    }
}

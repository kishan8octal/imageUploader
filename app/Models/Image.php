<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'path',
        'total_downloads'
    ];

    protected function getImageUrlAttribute()
    {
        if ($this->path) {
            return asset('storage/images/'.$this->path);
        } else {
            return asset('images/default.png');
        }
    }
}

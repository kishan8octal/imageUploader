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
        'total_downloads',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected function getImageUrlAttribute()
    {
        if ($this->path) {
            return asset('storage/images/'.$this->path);
        } else {
            return asset('images/default.png');
        }
    }

    public function downloadCount()
    {
        return $this->update([
            'total_downloads' => $this->total_downloads + 1,
        ]);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category_id', $category);
        });
    }

    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}

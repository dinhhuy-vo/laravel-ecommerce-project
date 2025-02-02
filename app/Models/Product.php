<?php

namespace App\Models;

use App\Traits\HandleUploadImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HandleUploadImageTrait;

    protected $fillable = [
        'name',
        'description',
        'sale',
        'price',
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function assignCategory($categoryIds)
    {
        $this->categories()->sync($categoryIds);
    }

    public function getBy($dataSearch, $category_id)
    {
        return $this->whereHas('categories', fn($q) => $q->where('category_id', $category_id))->paginate(8);
    }
}

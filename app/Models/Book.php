<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'book';
    protected $primaryKey = 'book_id';

    const UPDATED_AT = null;

    protected $fillable = [
        'category_id',
        'book_name',
        'author',
        'isbn',
        'language',
        'page_count',
        'total_quantity',
        'available_quantity',
        'location',
        'book_image',
        'description',
        'status',
        'slug',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
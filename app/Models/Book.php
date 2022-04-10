<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'title',
        'cover',
    ];

    public function pages(): HasMany
    {
        return $this->hasMany(BookPage::class, 'book_id', 'id');
    }
}

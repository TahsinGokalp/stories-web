<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookPage extends Model
{
    protected $fillable = [
        'book_id',
        'page_order',
        'image',
        'sound',
    ];

}

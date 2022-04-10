<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BookPage.
 *
 * @property int $id
 * @property int $book_id
 * @property int $page_order
 * @property string $image
 * @property string|null $sound
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BookPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookPage whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookPage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookPage wherePageOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookPage whereSound($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BookPage extends Model
{
    protected $fillable = [
        'book_id',
        'page_order',
        'image',
        'sound',
    ];

}

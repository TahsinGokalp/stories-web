<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Book.
 *
 * @property int $id
 * @property string $title
 * @property string $cover
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookPage[] $pages
 * @property-read int|null $pages_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property-read mixed $total_pages
 * @property-read string $audio_book_text
 */
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

    public function getTotalPagesAttribute()
    {
        return $this->hasMany(BookPage::class, 'book_id', 'id')->count();
    }

    public function getAudioBookTextAttribute()
    {
        $audioBook = (int)$this->attributes['audio_book'];
        return ($audioBook === 1) ? 'Sesli Kitap' : 'Kitap';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TranslationList extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    /**
     * Bu liste kime ait
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Bu listedeki tüm öğeler
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(TranslationListItem::class);
    }

    /**
     * Listedeki tüm çeviriler
     *
     * @return mixed
     */
    public function translations()
    {
        return $this->hasManyThrough(
            Translation::class,
            TranslationListItem::class,
            'translation_list_id',
            'id',
            'id',
            'translation_id'
        );
    }
} 
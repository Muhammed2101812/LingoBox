<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Translation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'source_text',
        'target_text',
        'source_lang_id',
        'target_lang_id',
        'category',
        'example_sentence',
    ];

    /**
     * Get the user that owns the translation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the source language of the translation.
     */
    public function sourceLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'source_lang_id');
    }

    /**
     * Get the target language of the translation.
     */
    public function targetLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'target_lang_id');
    }
    
    /**
     * Çevirinin eklendiği tüm liste öğeleri
     */
    public function listItems(): HasMany
    {
        return $this->hasMany(TranslationListItem::class);
    }
    
    /**
     * Çevirinin eklendiği tüm listeler
     */
    public function lists(): BelongsToMany
    {
        return $this->belongsToMany(
            TranslationList::class, 
            'translation_list_items', 
            'translation_id', 
            'translation_list_id'
        )->withTimestamps();
    }
    
    /**
     * Bu çeviriye ait flashcard ilerleme kaydı
     */
    public function flashcardProgress()
    {
        return $this->hasOne(FlashcardProgress::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlashcardProgress extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'flashcard_progress';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'translation_id',
        'status',
        'last_reviewed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_reviewed_at' => 'datetime',
        // 'status' alanı ENUM olduğu için Laravel otomatik olarak string'e cast edecektir.
        // Eğer özel bir Enum sınıfı kullansaydınız (PHP 8.1+), burada onu belirtebilirdiniz.
        // Örneğin: 'status' => YourStatusEnum::class,
    ];

    /**
     * Get the user that owns the flashcard progress.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the translation that the flashcard progress belongs to.
     */
    public function translation(): BelongsTo
    {
        return $this->belongsTo(Translation::class);
    }
}

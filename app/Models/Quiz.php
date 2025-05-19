<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     * We are only using created_at, so we need to manage this.
     */
    public $timestamps = true; // Eloquent'in created_at'ı yönetmesini sağlar

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = null; // updated_at sütununun olmadığını belirtir

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'score',
        'total_questions',
        // 'created_at' normalde fillable olmaz, otomatik yönetilir
    ];

    /**
     * Get the user that owns the quiz.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the questions for the quiz.
     * (Assumes a QuizQuestion model and quiz_questions table will be created later)
     */
    public function questions(): HasMany
    {
        // return $this->hasMany(QuizQuestion::class); // Sonraki adımda QuizQuestion modeli oluşturulacak
        return $this->hasMany(App\Models\QuizQuestion::class); // Tam namespace ile şimdilik tanımlayabiliriz
    }
}

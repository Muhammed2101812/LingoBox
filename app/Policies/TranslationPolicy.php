<?php

namespace App\Policies;

use App\Models\Translation;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TranslationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Herhangi bir kullanıcı listeyi görebilir (kendi çevirileri filtrelenecek)
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Translation $translation): bool
    {
        return $user->id === $translation->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Giriş yapmış her kullanıcı çeviri oluşturabilir
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Translation $translation): bool
    {
        return $user->id === $translation->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Translation $translation): bool
    {
        return $user->id === $translation->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Translation $translation): bool
    {
        return $user->id === $translation->user_id; // Genellikle soft delete ile kullanılır
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Translation $translation): bool
    {
        return $user->id === $translation->user_id; // Genellikle soft delete ile kullanılır
    }
}

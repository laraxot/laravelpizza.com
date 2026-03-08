<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\User;

/**
 * Trait Modules\User\Models\Traits\IsProfileTrait.
 *
 * Provides shared profile functionality for models that act as user profiles.
 *
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property User|null   $user
 */
trait IsProfileTrait
{
    /**
     * Boot the trait.
     */
    protected static function bootIsProfileTrait(): void
    {
        static::creating(static function ($model): void {
            if (null === $model->user_id && auth()->check()) {
                $model->user_id = auth()->id();
            }
        });
    }

    /**
     * Relazione con l'utente.
     */
    public function user(): BelongsTo
    {
        /** @var class-string<\Illuminate\Database\Eloquent\Model> $userClass */
        $userClass = config('auth.providers.users.model');

        return $this->belongsTo($userClass, 'user_id');
    }

    /**
     * Scope per filtrare per utente.
     */
    public function scopeOfUser(Builder $query, string|int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Ottiene il nome completo.
     */
    public function getFullNameAttribute(): string
    {
        return trim(($this->first_name ?? '').' '.($this->last_name ?? ''));
    }

    /**
     * Ottiene il nome visualizzato (per Filament).
     */
    public function getFilamentName(): string
    {
        $fullName = $this->getFullNameAttribute();

        return ! empty($fullName) ? $fullName : ($this->email ?? 'Profile #'.$this->getKey());
    }

    /**
     * Verifica se l'utente ha il ruolo di super-admin.
     */
    public function isSuperAdmin(): bool
    {
        $user = $this->user;
        if (null === $user) {
            return false;
        }

        return $user->hasRole('super-admin');
    }

    /**
     * Ottiene l'iniziale del nome.
     */
    public function getInitialsAttribute(): string
    {
        $first = ! empty($this->first_name) ? mb_substr($this->first_name, 0, 1) : '';
        $last = ! empty($this->last_name) ? mb_substr($this->last_name, 0, 1) : '';

        return mb_strtoupper($first.$last);
    }
}

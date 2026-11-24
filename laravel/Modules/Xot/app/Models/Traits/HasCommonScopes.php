<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Common query scopes for Laraxot models.
 *
 * Implements the strategy documented in METODI_DUPLICATI_ANALISI.md
 * Found 100% identical in 5 models across modules.
 *
 * Add this trait to models that need these scopes.
 *
 * Usage:
 * ```php
 * class MyModel extends BaseModel
 * {
 *     use HasCommonScopes;
 * }
 *
 * // Then use in queries:
 * MyModel::active()->get();
 * MyModel::published()->get();
 * ```
 *
 * @see Modules/Notify/docs/analisi-metodi-duplicati-master.md - Proposta 4: Model Traits
<<<<<<< .merge_file_qOvNKR
 * @see Modules/Meetup/docs/contracts/event-published-scope.md - mai su XotBaseModel (scopePublished)
 * @see Modules/Xot/docs/bmad/stories/phpstan-modules-zero-swarm-standing.story.md - consumer: NotificationTemplate|Module
 *
 * Trait di piattaforma riusabile: consumer nei modelli dominio.
 * Wire solo su NotificationTemplate e/o Module — mai su XotBaseModel.
=======
 *
 * Trait di piattaforma riusabile: consumer nei modelli dominio.
>>>>>>> .merge_file_qYjs0B
 */
trait HasCommonScopes
{
    /**
     * Scope query to only active records.
     *
     * Trovato identico in piu' moduli che condividono questo scope.
     *
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     *
     * @see Modules/Notify/docs/analisi-metodi-duplicati-master.md
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope query to only inactive records.
     *
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     *
     * @see Modules/Notify/docs/analisi-metodi-duplicati-master.md
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope query to published records.
     *
     * Records with published_at <= now().
     *
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     *
     * @see Modules/Notify/docs/analisi-metodi-duplicati-master.md
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope query to draft (unpublished) records.
     *
     * Records with published_at = null or > now().
     *
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     *
     * @see Modules/Notify/docs/analisi-metodi-duplicati-master.md
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where(function (Builder $q): void {
            $q->whereNull('published_at')
                ->orWhere('published_at', '>', now());
        });
    }

    /**
     * Scope query to records created after a date.
     *
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     *
     * @see Modules/Notify/docs/analisi-metodi-duplicati-master.md
     */
    public function scopeCreatedAfter(Builder $query, \DateTimeInterface|string|int $date): Builder
    {
        return $query->where('created_at', '>=', $date);
    }

    /**
     * Scope query to records created before a date.
     *
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     *
     * @see Modules/Notify/docs/analisi-metodi-duplicati-master.md
     */
    public function scopeCreatedBefore(Builder $query, \DateTimeInterface|string|int $date): Builder
    {
        return $query->where('created_at', '<=', $date);
    }

    /**
     * Scope query to records updated after a date.
     *
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     *
     * @see Modules/Notify/docs/analisi-metodi-duplicati-master.md
     */
    public function scopeUpdatedAfter(Builder $query, \DateTimeInterface|string|int $date): Builder
    {
        return $query->where('updated_at', '>=', $date);
    }

    /**
     * Scope query to records created by a specific user.
     *
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     *
     * @see Modules/Notify/docs/analisi-metodi-duplicati-master.md
     */
    public function scopeCreatedBy(Builder $query, string|int $userId): Builder
    {
        return $query->where('created_by', $userId);
    }

    /**
     * Check if the model is published.
     */
    public function isPublished(): bool
    {
        $publishedAt = $this->getAttribute('published_at');

        if (! $publishedAt instanceof Carbon) {
            return false;
        }

        return $publishedAt->isPast();
    }

    /**
     * Check if the model is draft.
     */
    public function isDraft(): bool
    {
        return ! $this->isPublished();
    }

    /**
     * Check if the model is active.
     */
    public function isActive(): bool
    {
        return $this->getAttribute('is_active') === true;
    }
}

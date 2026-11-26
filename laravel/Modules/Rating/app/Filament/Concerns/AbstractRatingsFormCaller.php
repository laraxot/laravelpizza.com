<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Concerns;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Collection;
use Modules\Rating\Contracts\RatingsFormCallerContract;
use Modules\Rating\Models\Contracts\RatingContract;

/**
 * Àncora PHPStan + default per host Filament: applica
 * {@see DecoratesRatingFormFields} e soddisfa {@see RatingsFormCallerContract}.
 * `final` così il trait resta analizzato anche senza page host che la estendono.
 *
 * @see Modules/Rating/docs/wiki/concepts/phpstan-compliance.md
 * @see Modules/Rating/docs/wiki/concepts/schema-form-dai-rating.md
 */
final class AbstractRatingsFormCaller implements RatingsFormCallerContract
{
    use DecoratesRatingFormFields;

    public function decorateRatingField(RatingContract $rating, Component $component): Component
    {
        return $this->applyDefaultRatingFieldDecoration($rating, $component);
    }

    /**
     * @param  Collection<int, RatingContract>  $readonlyRatings
     */
    public function recalculateRatingFields(Set $set, Get $get, Collection $readonlyRatings): void
    {
        // Default no-op: il ricalcolo è dominio dell'host concreto.
    }
}

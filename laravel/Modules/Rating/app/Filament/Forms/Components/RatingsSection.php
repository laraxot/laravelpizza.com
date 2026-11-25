<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Forms\Components;

use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Model;
use Modules\Rating\Filament\Tables\Columns\RatingsColumn;
use Modules\Xot\Filament\Forms\Components\XotBasePlaceholder;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

/**
 * Lo stato della valutazione nella scheda singola.
 *
 * Specchio di {@see RatingsColumn}: la lista mostra la stessa cosa in una cella,
 * qui la si legge distesa. Il criterio di «valutata» è **uno solo**, e sta in
 * `RatingsColumn::isRated()`: se le due classi lo calcolassero ognuna per conto
 * suo, prima o poi la lista direbbe una cosa e la scheda un'altra.
 *
 * Sono voci di sola lettura di proposito: i voti non si scrivono da qui, si
 * scrivono dove si valuta. Questa sezione dice **a che punto è**, non permette di
 * cambiarlo.
 *
 * @see docs/wiki/rules/form-column-parity.md
 */
class RatingsSection extends XotBaseSection
{
    protected const string DEFAULT_HEADING = 'ratings';

    /** @var array<string, Component> */
    public array $add = [];

    protected function setUp(): void
    {
        parent::setUp();

        if ($this->getHeading() === null) {
            $this->heading(static::DEFAULT_HEADING);
        }

        $this->refreshSchema();
    }

    /**
     * Campi aggiuntivi accodati a quelli standard.
     *
     * @param  array<string, Component>  $array
     */
    public function add(array $array): self
    {
        $this->add = array_merge($this->add, $array);
        $this->refreshSchema();

        return $this;
    }

    /**
     * @return array<string, Component>
     */
    public function getSchema(): array
    {
        return array_merge([
            'ratings_state' => XotBasePlaceholder::make('ratings_state')
                ->state(static fn (?Model $record): string => $record instanceof Model
                    ? RatingsColumn::describe(static::withAggregates($record))
                    : ''),
            'ratings_count' => XotBasePlaceholder::make('ratings_count')
                ->state(static fn (?Model $record): int => $record instanceof Model
                    ? (int) static::attribute($record, 'rating_morphs_count')
                    : 0),
            'ratings_sum_value' => XotBasePlaceholder::make('ratings_sum_value')
                ->state(static fn (?Model $record): string => $record instanceof Model
                    ? (string) (0 + (float) static::attribute($record, 'rating_morphs_sum_value'))
                    : '0'),
        ], $this->add);
    }

    /**
     * Gli stessi aggregati che la Column ottiene dalla query della tabella, qui su un
     * record solo. Si passa da `newQuery()->withCount()/withSum()` e non da
     * `$record->ratingMorphs()` perché il record arriva tipizzato `Model`: la relazione
     * vive sul trait, e chiamarla a mano su `Model` è una chiamata dinamica che
     * l'analisi statica non può verificare.
     */
    protected static function withAggregates(Model $record): Model
    {
        $loaded = $record->newQuery()
            ->whereKey($record->getKey())
            ->withCount('ratingMorphs')
            ->withSum('ratingMorphs', 'value')
            ->first();

        return $loaded instanceof Model ? $loaded : $record;
    }

    protected static function attribute(Model $record, string $name): float
    {
        $value = static::withAggregates($record)->getAttribute($name);

        return is_numeric($value) ? (float) $value : 0.0;
    }

    protected function refreshSchema(): void
    {
        $this->schema(array_values($this->getSchema()));
    }
}

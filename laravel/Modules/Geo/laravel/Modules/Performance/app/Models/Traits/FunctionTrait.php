<?php

declare(strict_types=1);

namespace Modules\Performance\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Performance\Actions\TrovaEsclusiAction;
use Modules\Performance\Models\CriteriEsclusione;
use Modules\Performance\Models\CriteriOption;
use Modules\Ptv\Enums\WorkerType;

/**
 * @template TModel of Model
 *
 * @property-read int|null $anno
 * @property-read string|WorkerType|null $type
 * @property-read Collection<int, Model> $codiciAssenze
 * @property-read Collection<int, Model> $options
 * @property-read Collection<int, Model> $criteriValutazione
 * @property-read \Modules\Performance\Models\CriteriOption|Collection<int, \Modules\Performance\Models\CriteriOption> $criteriOptions
 */
trait FunctionTrait
{
    /** @var array<string, mixed> */
    protected array $criteri_esclusione_anno = [];

    /** @var array<string, mixed> */
    protected array $criteri_options_anno = [];

    /** @var array<int, array<int|string, mixed>> */
    protected static array $cached_criteri_esclusione = [];

    /** @var array<int, array<int|string, mixed>> */
    protected static array $cached_criteri_options = [];

    /**
     * Get lista tipo codice assenze.
     *
     * @return array<int, string>
     */
    public function listaTipoCodiceAssenze(): array
    {
        /** @var array<int, string> */
        return $this->codiciAssenze->map(static fn ($item): string => (is_string($item->tipo) ? $item->tipo : (string) $item->tipo).'-'.(is_string($item->codice) ? $item->codice : (string) $item->codice)
        )->toArray();
    }

    /**
     * Get lista tipo codice aspettative.
     *
     * @return array<int, string>
     */
    public function getListaTipoCodiceAspettative(): array
    {
        return $this->listaTipoCodiceAssenze();
    }

    // Rimosso hhAssenzaFuoriSedeTot per evitare conflitti con SchedaTrait

    // Rimosso ggAssenzaInSedeTot per evitare conflitti con SchedaTrait

    // Rimosso ggAssenzaFuoriSedeTot per evitare conflitti con SchedaTrait

    // Rimosso ggInSedeTot per evitare conflitti con SchedaTrait

    // Rimosso ggFuoriSedeTot per evitare conflitti con SchedaTrait

    // Rimosso scopeOfYear per evitare conflitti con SchedaTrait

    // Rimosso scopeOfRangeDate per evitare conflitti con SchedaTrait

    // Rimosso getAventiDirittoAttribute e getAventiDirittoEffAttribute
    // per evitare conflitti con SchedaTrait

    /**
     * Get criteri options array.
     */
    public function criteriOptionsArr(string $key): mixed
    {
        $criteri = $this->criteriOptions->where('key', $key)->first();

        return $criteri?->value;
    }

    public function check(string $name, mixed $value): string
    {
        $year = $this->anno;
        $trovaEsclusiAction = new TrovaEsclusiAction;
        $trovaEsclusiAction->year = $year ?? 0;

        // @phpstan-ignore-next-line
        return $trovaEsclusiAction->check($name, (string) $value, $this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, \Modules\Performance\Models\Option>
     */
    public function optionsCriteriOrdered(): \Illuminate\Support\Collection
    {
        $criteri = $this->options->where('name', 'criterio')->where('parent_id', 0)->sortBy('pos');

        $criteri1 = $this->criteriValutazione->sortBy('posizione');
        foreach ($criteri as $v) {
            $v1 = $criteri1->firstWhere('nome', $v->value);
            if ($v1 !== null) {
                $v->pos = $v1->posizione;
                $v->save();
            }
        }

        return $criteri;
    }

    /**
     * Get criteri options for a specific year.
     *
     * @return array<int, array<int|string, mixed>>
     */
    public function criteriOptionsYear(int $year): array
    {
        if (isset(static::$cached_criteri_options[$year])) {
            /** @var array<int, array<int|string, mixed>> */
            return static::$cached_criteri_options[$year];
        }

        $options = CriteriOption::where('anno', $year)
            ->get()
            ->map(fn ($item) => $item->toArray())
            ->values() // Force sequential numeric indices
            ->toArray();

        /** @var array<int, array<int|string, mixed>> $options */
        static::$cached_criteri_options[$year] = $options;

        return static::$cached_criteri_options[$year];
    }

    /**
     * Get criteri esclusione for a specific year.
     *
     * @return array<int, array<int|string, mixed>>
     */
    public function criteriEsclusioneYear(int $year): array
    {
        if (isset(static::$cached_criteri_esclusione[$year])) {
            /** @var array<int, array<int|string, mixed>> */
            return static::$cached_criteri_esclusione[$year];
        }

        $esclusioni = CriteriEsclusione::where('anno', $year)
            ->get()
            ->map(fn ($item) => $item->toArray())
            ->values() // Force sequential numeric indices
            ->toArray();

        /** @var array<int, array<int|string, mixed>> $esclusioni */
        static::$cached_criteri_esclusione[$year] = $esclusioni;

        return static::$cached_criteri_esclusione[$year];
    }

    /**
     * @return array{int, string}
     */
    public function getHaDirittoEMotivo(): array
    {
        $anno = $this->anno;
        if ($anno === null) {
            $anno = request('year');
            if ($anno !== null) {
                $anno = (int) $anno;
            } else {
                $anno = 0; // Default year if none provided
            }
        }

        $criteri_esclusione = $this->criteriEsclusioneYear($anno);
        $ha_diritto = 1;
        $motivo = '';
        foreach ($criteri_esclusione as $ce) {
            $name = is_string($ce['name']) ? $ce['name'] : (string) $ce['name'];
            $msg = $this->check($name, $ce['value']);
            if ($msg !== '') {
                $motivo .= ', '.$msg;
                $ha_diritto = 0;
            }
        }

        return [$ha_diritto, $motivo];
    }

    public function getPeso(string $name): int
    {
        $peso = $this->peso;
        $field = 'peso_'.$name;
        $value = $peso?->getAttributeValue($field);
        if (is_int($value)) {
            return $value;
        }

        return 0;
    }

    public function getPesoFunc(string $func, ?float $value): ?float
    {
        if ($value !== null && $this->posfun < 100) {
            return $value;
        }

        $name = Str::snake(Str::before(Str::after($func, 'get'), 'Attribute'));
        if (! \is_object($this->peso)) {
            return null;
        }

        $peso = $this->posfun >= 100 ? $this->pesoPo : $this->peso;
        if (! \is_object($peso)) {
            dddx([
                'this' => $this,
                'posfun' => $this->posfun,
                'pesoPo' => $this->pesoPo()->toSql(),
                'peso' => $this->peso()->toSql(),
            ]);

            return null;
        }

        $value = $peso->$name;
        $this->$name = $value;

        if ($this->getKey() !== null) {
            $this->update([
                $name => $value,
            ]);
        }

        return (float) $value;
    }

    public function setValutazioneFunc(string $func, mixed $value): void
    {
        $name = Str::snake(Str::before(Str::after($func, 'set'), 'Attribute'));
        // $value = number_format((float) $value, 1);
        $this->attributes[$name] = $value;
    }

    public function option(string $name): string
    {
        $option = $this->options->firstWhere('name', $name);
        if (! $option instanceof Model) {
            return sprintf(
                '<h3 style="color:red">andare su options e popolare:
                <ul>
                <li>option_type [%s]</li>
                <li>name [%s]</li>
                <li>year [%s]</li>
                </ul>
                </h3>',
                $this->getType(),
                $name,
                (string) $this->anno
            );
        }
        if (strlen((string) $option->value)) {
            return (string) $option->value;
        }

        return (string) ($option->txt ?? '');
    }

    protected function getType(): string
    {
        $type = $this->getAttribute('type');

        return $type instanceof WorkerType
            ? $type->value
            : (string) ($type ?? 'dip');
    }

    public function isPo(): bool
    {
        $posfun = (int)($this->attributes['posfun'] ?? 0);
        
        $isPo = $posfun >= 100;
        return $isPo;
    }

    public function isRegionale(): bool
    {
        $disci1 = (int) ($this->attributes['disci1'] ?? 0);
        $isRegionale = $disci1 == 203;
        
        return $isRegionale;
    }

    public function isDirigente(): bool
    {
        $propro = $this->getAttributeValue('propro');
        if ($propro === null) {
            return false;
        }

        return in_array($propro, [729, 750, 751]);
    }

    /**
     * Undocumented function.
     */
    /**
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    public function scopeWithTotPunt(Builder $query): Builder
    {
        return $query;
    }

    public function canSendEmail(): bool
    {
        return (int) ($this->ha_diritto ?? 0) !== 0
            && (float) ($this->totale_punteggio ?? 0) > 1;
    }
}

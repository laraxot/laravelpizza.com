<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Modules\Geo\Models\Comune;
use Modules\Xot\Filament\Schemas\Components\XotBaseGroup;

/**
 * LocationSelector Component - Selezione geografica gerarchica.
 *
 * Componente Filament per la selezione gerarchica di:
 * - Regione
 * - Provincia (dipendente da regione)
 * - CAP (dipendente da regione e provincia)
 */
class LocationSelector extends XotBaseGroup
{
    /**
     * Il nome del campo regione.
     */
    protected string $regionFieldName = 'region';

    /**
     * Il nome del campo provincia.
     */
    protected string $provinceFieldName = 'province';

    /**
     * Il nome del campo CAP.
     */
    protected string $capFieldName = 'cap';

    /**
     * Se i campi devono essere searchable.
     */
    protected bool $searchable = true;

    /**
     * Se i campi devono essere required.
     */
    protected bool $required = false;

    /**
     * Label personalizzate per i campi.
     */
    protected array $labels = [];

    /**
     * Placeholder personalizzati per i campi.
     */
    protected array $placeholders = [];

    /**
     * Setup del componente.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->schema($this->getChildComponentsSchema());
    }

    /**
     * Imposta il nome del campo regione.
     */
    public function regionField(string $fieldName): static
    {
        $this->regionFieldName = $fieldName;

        return $this;
    }

    /**
     * Imposta il nome del campo provincia.
     */
    public function provinceField(string $fieldName): static
    {
        $this->provinceFieldName = $fieldName;

        return $this;
    }

    /**
     * Imposta il nome del campo CAP.
     */
    public function capField(string $fieldName): static
    {
        $this->capFieldName = $fieldName;

        return $this;
    }

    /**
     * Rende tutti i campi required.
     */
    public function required(bool $condition = true): static
    {
        $this->required = $condition;

        return $this;
    }

    /**
     * Abilita/disabilita la ricerca in tutti i select.
     */
    public function searchable(bool $condition = true): static
    {
        $this->searchable = $condition;

        return $this;
    }

    /**
     * Imposta label personalizzate.
     *
     * @param array<string, string> $labels
     */
    public function labels(array $labels): static
    {
        $this->labels = array_merge($this->labels, $labels);

        return $this;
    }

    /**
     * Imposta placeholder personalizzati.
     *
     * @param array<string, string> $placeholders
     */
    public function placeholders(array $placeholders): static
    {
        $this->placeholders = array_merge($this->placeholders, $placeholders);

        return $this;
    }

    /**
     * Validazione custom per verificare la coerenza dei dati.
     */
    public function validate(): array
    {
        $state = $this->getState();
        $errors = [];

        // Verifica che se è selezionata una provincia, sia selezionata anche la regione
        /* @phpstan-ignore offsetAccess.nonOffsetAccessible, offsetAccess.nonOffsetAccessible */
        if (! empty($state[$this->provinceFieldName]) && empty($state[$this->regionFieldName])) {
            $errors[] = __('ui::location_selector.validation.region_required_for_province');
        }

        // Verifica che se è selezionato un CAP, siano selezionate regione e provincia
        if (\is_array($state)) {
            $capValue = $state[$this->capFieldName] ?? null;
            $regionValue = $state[$this->regionFieldName] ?? null;
            $provinceValue = $state[$this->provinceFieldName] ?? null;

            if (! empty($capValue) && (empty($regionValue) || empty($provinceValue))) {
                $errors[] = __('ui::location_selector.validation.region_province_required_for_cap');
            }
        }

        return $errors;
    }

    /**
     * Ottiene i dati geografici completi basati sulla selezione corrente.
     *
     * @return array<string, mixed>|null
     */
    public function getGeographicData(): ?array
    {
        $state = $this->getState();
        if (! \is_array($state) || empty($state[$this->regionFieldName])) {
            return null;
        }

        /** @var array<string, mixed> $validatedState */
        $validatedState = $state;
        try {
            $comune = $this->getComuneFromState($validatedState);

            return $comune ? $this->formatGeographicData($comune, $validatedState) : null;
        } catch (\Exception $e) {
            logger()->error('LocationSelector: Errore nel recupero dati geografici', [
                'state' => $validatedState,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Genera lo schema dei componenti figlio.
     *
     * @return array<Component>
     */
    protected function getChildComponentsSchema(): array
    {
        return [
            $this->getRegionComponent(),
            $this->getProvinceComponent(),
            $this->getCapComponent(),
        ];
    }

    protected function getRegionComponent(): Select
    {
        return Select::make($this->regionFieldName)
            ->options($this->getRegionOptions())
            ->searchable($this->searchable)
            ->required($this->required)
            ->live()
            ->afterStateUpdated(function (Set $set) {
                // Reset province e cap quando cambia la regione
                $set($this->provinceFieldName, null);
                $set($this->capFieldName, null);
            });
    }

    protected function getProvinceComponent(): Select
    {
        return Select::make($this->provinceFieldName)
            ->options(function (Get $get): array {
                $region = $get($this->regionFieldName);

                return \is_string($region) ? $this->getProvinceOptions($region) : [];
            })
            ->searchable($this->searchable)
            ->required($this->required)
            ->live()
            ->disabled(fn (Get $get): bool => ! $get($this->regionFieldName))
            ->afterStateUpdated(function (Set $set) {
                // Reset cap quando cambia la provincia
                $set($this->capFieldName, null);
            });
    }

    protected function getCapComponent(): Select
    {
        return Select::make($this->capFieldName)
            ->options(function (Get $get): array {
                $region = $get($this->regionFieldName);
                $province = $get($this->provinceFieldName);

                return \is_string($region) && \is_string($province) ? $this->getCapOptions($region, $province) : [];
            })
            ->searchable($this->searchable)
            ->required($this->required)
            ->disabled(fn (Get $get): bool => ! $get($this->regionFieldName) || ! $get($this->provinceFieldName));
    }

    /**
     * Ottiene le opzioni per il campo regione.
     *
     * @return array<string, string>
     */
    protected function getRegionOptions(): array
    {
        try {
            /* @phpstan-ignore return.type */
            return Comune::select('regione')
                ->distinct()
                ->orderBy('regione->nome')
                ->get()
                ->pluck('regione.nome', 'regione.codice')
                ->toArray();
        } catch (\Exception $e) {
            // Log dell'errore per debug
            logger()->error('LocationSelector: Errore nel caricamento regioni', [
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    /**
     * Ottiene le opzioni per il campo provincia basate sulla regione.
     *
     * @param string $region Codice regione
     *
     * @return array<string, string>
     */
    protected function getProvinceOptions(string $region): array
    {
        try {
            /* @phpstan-ignore return.type */
            return Comune::query()
                ->where('regione->codice', $region)
                ->select('provincia')
                ->distinct()
                ->orderBy('provincia->nome')
                ->get()
                ->pluck('provincia.nome', 'provincia.codice')
                ->toArray();
        } catch (\Exception $e) {
            logger()->error('LocationSelector: Errore nel caricamento province', [
                'region' => $region,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    /**
     * Ottiene le opzioni per il campo CAP basate su regione e provincia.
     *
     * @param string $region   Codice regione
     * @param string $province Codice provincia
     *
     * @return array<string, string>
     */
    protected function getCapOptions(string $region, string $province): array
    {
        try {
            /* @phpstan-ignore return.type */
            return Comune::query()
                ->where('regione->codice', $region)
                ->where('provincia->codice', $province)
                ->select('cap')
                ->distinct()
                ->orderBy('cap')
                ->get()
                ->pluck('cap.0', 'cap.0')
                ->toArray();
        } catch (\Exception $e) {
            logger()->error('LocationSelector: Errore nel caricamento CAP', [
                'region' => $region,
                'province' => $province,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    protected function getComuneFromState(mixed $state): ?Comune
    {
        if (! \is_array($state)) {
            return null;
        }

        /** @var array<string, mixed> $state */
        $query = Comune::query()->where('regione->codice', $state[$this->regionFieldName]);

        if (! empty($state[$this->provinceFieldName])) {
            $query->where('provincia->codice', $state[$this->provinceFieldName]);
        }

        if (! empty($state[$this->capFieldName])) {
            $query->where('cap->0', $state[$this->capFieldName]);
        }

        /* @phpstan-ignore return.type */
        return $query->first();
    }

    /**
     * @param array<string, mixed> $state
     *
     * @return array<string, mixed>
     */
    protected function formatGeographicData(Comune $comune, array $state): array
    {
        $regione = \is_array($comune->regione) ? $comune->regione : [];
        $provincia = \is_array($comune->provincia) ? $comune->provincia : [];

        return [
            'region' => [
                'code' => $regione['codice'] ?? null,
                'name' => $regione['nome'] ?? null,
            ],
            'province' => [
                'code' => $provincia['codice'] ?? null,
                'name' => $provincia['nome'] ?? null,
            ],
            'cap' => $state[$this->capFieldName] ?? null,
            'city' => $comune->nome ?? null,
        ];
    }
}

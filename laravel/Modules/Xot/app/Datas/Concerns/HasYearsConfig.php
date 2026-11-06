<?php

declare(strict_types=1);

namespace Modules\Xot\Datas\Concerns;

/**
 * Anni proposti dai filtri/select di un modulo, modificabili dalla SettingPage.
 *
 * Prima ogni modulo li aveva scritti nel codice (Progressioni, Ptv, IR, ICL, Incentivi, spesso
 * fermi al 2023 o al 2025): ogni anno nuovo era un deploy. Il default di ogni modulo e' l'elenco
 * che c'era nel suo codice (`defaultAnni()`), quindi nulla cambia finche' nessuno salva.
 *
 * La Data che usa il trait chiama `static::prepareAnni($properties)` dal proprio
 * `prepareForPipeline()`.
 */
trait HasYearsConfig
{
    /**
     * @var list<int>
     */
    public array $anni = [];

    /**
     * @return array<int, string>
     */
    public function getAnniOptions(): array
    {
        $options = [];
        foreach (array_reverse($this->anni) as $anno) {
            $options[$anno] = (string) $anno;
        }

        return $options;
    }

    /**
     * Elenco usato finche' il file del tenant non ha `anni`. Da sovrascrivere nel modulo.
     *
     * @return list<int>
     */
    protected static function defaultAnni(): array
    {
        $year = (int) date('Y');

        return [$year - 2, $year - 1, $year];
    }

    /**
     * TagsInput restituisce stringhe e il file puo' essere scritto a mano: interi unici e ordinati.
     *
     * @param  array<array-key, mixed>  $properties
     * @return array<array-key, mixed>
     */
    protected static function prepareAnni(array $properties): array
    {
        $anni = $properties['anni'] ?? static::defaultAnni();
        $properties['anni'] = static::normalizeAnni(is_array($anni) ? $anni : []);

        return $properties;
    }

    /**
     * @param  array<array-key, mixed>  $anni
     * @return list<int>
     */
    protected static function normalizeAnni(array $anni): array
    {
        $years = [];
        foreach ($anni as $anno) {
            $value = is_string($anno) ? trim($anno) : $anno;
            if (is_int($value) || (is_string($value) && ctype_digit($value))) {
                $years[] = (int) $value;
            }
        }

        $years = array_values(array_unique($years));
        sort($years);

        return $years;
    }
}

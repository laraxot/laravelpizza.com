<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models\Traits;

// ----- models------
use Illuminate\Database\Eloquent\Relations\HasMany;

// ----- services -----

// ------ traits ---

trait ConvertedTrait
{
    /**
     * Convert field value based on conversion type.
     *
     * @param  string  $field  The dynamic field name to convert
     * @param  int  $converted_in  The conversion type (1-5)
     */
    public function convertedIn(string $field, int $converted_in): float|int|null
    {
        // Use isset() instead of property_exists() for Eloquent models
        if (! isset($this->$field)) {
            return null;
        }

        /** @var mixed $fieldValue */
        $fieldValue = $this->$field;

        switch ($converted_in) {
            case 1: // 'max 10 valutatore'
                return $this->rapportatoMax10Valutatore($field);
            case 2: // 'se stesso'
                return is_numeric($fieldValue) ? (float) $fieldValue : null;
            case 3: // 'da 4 a 10'
                return is_numeric($fieldValue) ? $fieldValue * 2.5 : 0;
            case 4: // 'div 10'
                return is_numeric($fieldValue) ? $fieldValue * 0.1 : 0;
            case 5: // 'fino 10 anni'
                if (! is_numeric($fieldValue)) {
                    return 0;
                }
                $anni = $fieldValue / 365;
                if ($anni > 10) {
                    return 10;
                }

                return $anni;
            default:
                dddx(['conversione non riconosciuta']);
                break;
        }

        return null;
    }

    /**
     * @return HasMany<static, $this>
     */
    public function avversari(): HasMany
    {
        return $this->hasMany(static::class, 'valutatore_id', 'valutatore_id')
            ->where('anno', $this->anno)
            ->where('ha_diritto', 1);
    }

    /**
     * @return HasMany<static, $this>
     */
    public function avversariCategoriaEco(): HasMany
    {
        return $this->hasMany(static::class, 'valutatore_id', 'valutatore_id')
            ->where('anno', $this->anno)
            ->where('ha_diritto', 1)
            ->where('categoria_eco', $this->categoria_eco);
    }

    /**
     * Calculate ratio against max value in same category.
     *
     * @param  string  $field  The field to compare
     */
    public function rapportatoMax10Valutatore(string $field): float
    {
        $max = $this->avversariCategoriaEco->max($field);

        // Use isset() for dynamic property access
        if (! isset($this->$field)) {
            return 0.0;
        }

        /** @var mixed $value */
        $value = $this->$field;

        if (! is_numeric($max) || $max == 0 || ! is_numeric($value)) {
            return 0.0;
        }

        return (float) $value * 10 / (float) $max;
    }

    /**
     * Get calculated gg_cateco_posfun ratio.
     *
     * @param  string  $_value  Unused parameter (legacy)
     */
    public function getGgCatecoPosfunRapportatoMax10ValutatoreAttribute(string $_value): float
    {
        $field = 'gg_cateco_posfun';
        $max = $this->avversariCategoriaEco->max($field);

        // Use isset() for dynamic property access
        if (! isset($this->$field)) {
            return 0.0;
        }

        /** @var mixed $value */
        $value = $this->$field;

        if (! is_numeric($max) || $max == 0 || ! is_numeric($value)) {
            return 0.0;
        }

        return (float) $value * 10 / (float) $max;
    }
}

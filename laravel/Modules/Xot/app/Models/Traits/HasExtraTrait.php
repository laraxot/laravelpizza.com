<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Modules\Xot\Contracts\ExtraContract;
use Spatie\SchemalessAttributes\SchemalessAttributes;
use Webmozart\Assert\Assert;

use function Safe\json_encode;

/**
 * Modules\Xot\Models\HasExtraTrait.
 *
 * @property string $currency
 * @property float $price
 * @property string $price_complete
 * @property int $qty
 * @property ExtraContract|null $extra
 */
trait HasExtraTrait
{
    /**
     * Retrieves the morphed one-to-one relationship between the current model and the Extra model.
     *
     * return MorphOne<ExtraContract>
     */
    public function extra(): MorphOne
    {
        $extra_class = Str::of(static::class)
            ->before('\Models\\')
            ->append('\Models\Extra')
            ->toString();
        Assert::classExists($extra_class);
        Assert::isAOf(
            $extra_class,
            Model::class,
            '['.__LINE__.']['.class_basename($this).']['.$extra_class.']',
        );
        // Assert::isInstanceOf($extra_class, ExtraContract::class, '['.__LINE__.']['.class_basename($this).']['.$extra_class.']');
        // Assert::implementsInterface($extra_class, ExtraContract::class, '['.__LINE__.']['.class_basename($this).']['.$extra_class.']');

        return $this->morphOne($extra_class, 'model');
    }

    public function getExtra(string $name): array|bool|float|int|string|null
    {
        $extra = $this->extra;
        if (! $extra instanceof ExtraContract || ! $extra instanceof Model) {
            return null;
        }

        $attributes = $extra->extra_attributes;
        if (! $attributes instanceof SchemalessAttributes) {
            return null;
        }

        $value = $attributes->get($name);

        if (\is_array($value)) {
            return $value;
        }

        if (\is_bool($value) || \is_float($value) || \is_int($value) || \is_string($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param  int|float|string|array<string, mixed>|bool|null  $value
     */
    public function setExtra(string $name, int|float|string|array|bool|null $value): void
    {
        $extra = $this->extra;
        if (! $extra instanceof ExtraContract || ! $extra instanceof Model) {
            $extra = $this->extra()->firstOrCreate([], ['extra_attributes' => json_encode([])]);
            if (! $extra instanceof ExtraContract || ! $extra instanceof Model) {
                return;
            }
        }

        $attributes = $extra->extra_attributes;
        if (! $attributes instanceof SchemalessAttributes) {
            $extra->extra_attributes = $attributes = new SchemalessAttributes($extra, 'extra_attributes');
        }

        $attributes->set($name, $value);
        $extra->save();
    }
}

<?php

declare(strict_types=1);

namespace Modules\Cms\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Modules\Cms\Datas\BlockData;
use Modules\Xot\Datas\XotData;
use Spatie\LaravelData\DataCollection;

/**
 * Trait for Models that have blocks.
 *
 * @phpstan-require-extends Model
 */
trait HasBlocks
{
    /**
     * @return DataCollection<BlockData>
     */
    public function getBlocks(): DataCollection
    {
        $blocks = $this->blocks;

        if (is_array($blocks) && count($blocks) > 0 && is_string(array_key_first($blocks)) && 2 === strlen(array_key_first($blocks))) {
            $primary_lang = XotData::make()->primary_lang;
            $blocks = $this->getTranslation('blocks', app()->getLocale() ?: $primary_lang);
        }

        if (! is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            $blocks = $this->getTranslation('blocks', app()->getLocale() ?: $primary_lang);
        }

        if (! is_array($blocks)) {
            $blocks = [];
        }

        $blocks = $this->compile($blocks);

        /* @var DataCollection<BlockData> $collection */
        return BlockData::collection($blocks);
    }

    /**
     * @return array<string, mixed>
     */
    public function compile(array $blocks): array
    {
        $result = [];

        foreach ($blocks as $key => $value) {
            if (! is_string($key)) {
                $key = (string) $key;
            }

            if (is_string($value) && Str::containsAll($value, ['{{', '}}'])) {
                $result[$key] = Blade::render($value);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Get blocks for a record by slug.
     *
     * @return DataCollection<BlockData>
     */
    public static function getBlocksBySlug(string $slug): DataCollection
    {
        // This trait requires the class to extend Model (@phpstan-require-extends Model)
        // So we can safely use static methods
        $query = static::where('slug', $slug);

        if (! method_exists($query, 'first')) {
            return BlockData::collection([]);
        }

        $record = $query->first();
        if (! $record instanceof Model) {
            return BlockData::collection([]);
        }

        // Check if getBlocks method exists
        if (! method_exists($record, 'getBlocks')) {
            return BlockData::collection([]);
        }

        /** @var DataCollection<BlockData> $blocks */
        $blocks = $record->getBlocks();

        return $blocks;
    }
}

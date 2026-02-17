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
     * @return DataCollection<BlockData>|array
     */
    public function getBlocks(?string $side = null)
    {
        $field = 'blocks';
        if ($side) {
            $field = $side.'_blocks';
        }
        $blocks = $this->{$field};

        if (! is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            $blocks = $this->getTranslation($field, $primary_lang);
        }

        if (! is_array($blocks)) {
            $blocks = [];
        }

        $blocks = $this->compile($blocks);

        // Create BlockData instances manually to ensure constructor is called
        // This is necessary because Laravel Data's collect() doesn't call custom constructors
        // which is needed for dynamic query resolution
        $blockDataInstances = array_map(function (array $block): BlockData {
            $type = $block['type'] ?? 'unknown';
            $data = $block['data'] ?? [];
            $slug = $block['slug'] ?? null;

            return new BlockData($type, $data, $slug);
        }, $blocks);

        return BlockData::collection($blockDataInstances);
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
            if (is_array($value)) {
                $result[$key] = $this->compile($value);
            }
        }

        return $result;
    }

    /**
     * Get blocks for a record by slug.
     *
     * @return DataCollection<BlockData>|array
     */
    public static function getBlocksBySlug(string $slug, ?string $side = null)
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

        /** @var DataCollection<BlockData>|array $blocks */
        $blocks = $record->getBlocks($side);

        return $blocks;
    }
}

<?php

declare(strict_types=1);

namespace Modules\Cms\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Modules\Cms\Datas\BlockData;
use Modules\Xot\Datas\XotData;

/**
 * Trait for Models that have blocks.
 *
 * @phpstan-require-extends Model
 *
 * @method        mixed                                         getTranslation(string $key, string $locale, bool $useFallbackLocale = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static> query()
 */
trait HasBlocks
{
    /**
     * @return array<string, BlockData>
     */
    public function getBlocks(?string $side = null): array
    {
        $field = 'blocks';
        if ($side) {
            $field = $side.'_blocks';
        }
        $blocks = $this->{$field};

        // Handle translatable fields: if blocks is an array with locale keys,
        // extract the current language's content
        if (is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            // Check if this looks like a translatable structure (has locale keys)
            $localeKeys = ['it', 'en', 'fr', 'de', 'es', $primary_lang];
            $hasLocaleKeys = count(array_intersect(array_keys($blocks), $localeKeys)) > 0;
            if ($hasLocaleKeys) {
                $blocks = $this->getTranslation($field, $primary_lang);
            }
        }

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
        $blockDataInstances = [];
        foreach ($blocks as $key => $block) {
            if (! is_array($block)) {
                continue;
            }
            $type = (string) ($block['type'] ?? 'unknown');
            /** @var array<string, mixed> $data */
            $data = (array) ($block['data'] ?? []);
            $slug = isset($block['slug']) ? (string) $block['slug'] : null;
            $active = (bool) ($block['active'] ?? true);

            $blockDataInstances[(string) $key] = new BlockData($type, $data, $slug, $active);
        }

        /* @var array<string, BlockData> $blockDataInstances */

        // Return array directly to ensure BlockData constructor is called for dynamic query resolution
        return $blockDataInstances;
    }

    /**
     * @param array<int|string, mixed> $blocks
     *
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
     * Get blocks by slug for a specific side.
     *
     * Cercato il record per slug, itera sui blocchi e filtra per side quando fornito.
     * Struttura attesa: blocks = [{type, data, slug?, side?}, ...]
     *
     * @param string      $slug The section/page slug
     * @param string|null $side The side to get blocks for (null for all blocks)
     *
     * @return array<string, BlockData>
     */
    public static function getBlocksBySlug(string $slug, ?string $side = null): array
    {
        try {
            $record = static::query()->where('slug', $slug)->sole();
        } catch (ModelNotFoundException) {
            return [];
        }

        if (! $record instanceof Model) {
            return [];
        }

        // Check if getBlocks method exists
        if (! method_exists($record, 'getBlocks')) {
            return [];
        }

        /** @var array<string, BlockData> $blocks */
        $blocks = $record->getBlocks($side);

        return $blocks;
    }
}

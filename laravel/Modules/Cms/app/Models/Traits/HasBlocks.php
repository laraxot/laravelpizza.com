<?php

declare(strict_types=1);

namespace Modules\Cms\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Modules\Cms\Datas\BlockData;
use Modules\Xot\Datas\XotData;

/**
 * Trait for Models that have blocks.
 *
 * @method static array<string, BlockData> getBlocksBySlug(string $slug, ?string $side = null)
 *
 * @phpstan-require-extends Model
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
            /** @var array<string, mixed> $block */
            $type = (string) ($block['type'] ?? 'unknown');
            $data = (array) ($block['data'] ?? []);
            $slug = isset($block['slug']) ? (string) $block['slug'] : null;

            try {
                $blockDataInstances[(string) $key] = new BlockData($type, $data, $slug);
            } catch (\Throwable) {
                continue;
            }
        }

        /* @var array<string, BlockData> $blockDataInstances */

        // Return array directly to ensure BlockData constructor is called for dynamic query resolution
        return $blockDataInstances;
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
     * Get blocks by slug for a specific side.
     *
     * Cercato il record per slug, itera sui blocchi e filtra per side quando fornito.
     * Struttura attesa: blocks = [{type, data, slug?, side?}, ...]
     *
     * @param  string  $slug  The section/page slug
     * @param  string|null  $side  The side to get blocks for (null for all blocks)
     * @return array<string, BlockData>
     */
    public static function getBlocksBySlug(string $slug, ?string $side = null): array
    {
        $record = static::where('slug', $slug)->first();

        if (! $record instanceof Model) {
            return [];
        }

        $blocks = $record->blocks ?? null;

        if (! is_array($blocks)) {
            if (method_exists($record, 'getBlocks')) {
                /** @var array<string, BlockData> $result */
                $result = $record->getBlocks($side);

                return $result;
            }

            return [];
        }

        $result = [];

        foreach ($blocks as $block) {
            if (! is_array($block)) {
                continue;
            }

            $blockType = (string) ($block['type'] ?? 'text');
            $blockData = is_array($block['data'] ?? null) ? $block['data'] : [];
            $blockSlug = isset($block['slug']) ? (string) $block['slug'] : null;

            try {
                $blockDataObj = new BlockData($blockType, $blockData, $blockSlug);

                if ($side === null) {
                    $result[$blockSlug ?? $blockType] = $blockDataObj;
                } elseif (isset($block['side']) && (string) $block['side'] === $side) {
                    $result[$blockSlug ?? $blockType] = $blockDataObj;
                }
            } catch (\Throwable) {
                continue;
            }
        }

        return $result;
    }
}

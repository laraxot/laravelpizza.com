<?php

declare(strict_types=1);

namespace Modules\AI\Datas;

use Modules\AI\Support\ScalarCaster;

class OpenAiPredictionMapper
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function toPredictionData(array $data): PredictionData
    {
        return PredictionData::from([
            'title' => ScalarCaster::string($data['title'] ?? ''),
            'description' => ScalarCaster::string($data['description'] ?? ''),
            'content' => ScalarCaster::string($data['content'] ?? ''),
            'excerpt' => ScalarCaster::string($data['excerpt'] ?? $data['description'] ?? ''),
            'category' => ScalarCaster::string($data['category'] ?? 'Generico'),
            'tags' => ScalarCaster::stringList($data['tags'] ?? []),
            'closedAt' => ScalarCaster::string($data['closed_at'] ?? now()->addDays(30)->format('Y-m-d')),
            'endsAt' => ScalarCaster::string($data['ends_at'] ?? now()->addDays(60)->format('Y-m-d')),
            'liquidityParameter' => is_numeric($data['liquidity_parameter'] ?? null) ? (float) $data['liquidity_parameter'] : 0.5,
            'stocksCount' => is_numeric($data['stocks_count'] ?? null) ? (int) $data['stocks_count'] : 1000,
            'isWagerable' => is_bool($data['is_wagerable'] ?? null) ? $data['is_wagerable'] : true,
            'contentBlock' => ScalarCaster::nullableString($data['content_block'] ?? null),
            'sidebarBlock' => ScalarCaster::nullableString($data['sidebar_block'] ?? null),
            'footerBlock' => ScalarCaster::nullableString($data['footer_block'] ?? null),
        ]);
    }
}

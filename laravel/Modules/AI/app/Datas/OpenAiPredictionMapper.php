<?php

declare(strict_types=1);

namespace Modules\AI\Datas;

use Modules\AI\Actions\Cast\ScalarCasterAction;

class OpenAiPredictionMapper
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function toPredictionData(array $data): PredictionData
    {
        $caster = app(ScalarCasterAction::class);

        return PredictionData::from([
            'title' => $caster->execute($data['title'] ?? ''),
            'description' => $caster->execute($data['description'] ?? ''),
            'content' => $caster->execute($data['content'] ?? ''),
            'excerpt' => $caster->execute($data['excerpt'] ?? $data['description'] ?? ''),
            'category' => $caster->execute($data['category'] ?? 'Generico'),
            'tags' => $caster->stringList($data['tags'] ?? []),
            'closedAt' => $caster->execute($data['closed_at'] ?? now()->addDays(30)->format('Y-m-d')),
            'endsAt' => $caster->execute($data['ends_at'] ?? now()->addDays(60)->format('Y-m-d')),
            'liquidityParameter' => is_numeric($data['liquidity_parameter'] ?? null) ? (float) $data['liquidity_parameter'] : 0.5,
            'stocksCount' => is_numeric($data['stocks_count'] ?? null) ? (int) $data['stocks_count'] : 1000,
            'isWagerable' => is_bool($data['is_wagerable'] ?? null) ? $data['is_wagerable'] : true,
            'contentBlock' => $caster->nullableString($data['content_block'] ?? null),
            'sidebarBlock' => $caster->nullableString($data['sidebar_block'] ?? null),
            'footerBlock' => $caster->nullableString($data['footer_block'] ?? null),
        ]);
    }
}

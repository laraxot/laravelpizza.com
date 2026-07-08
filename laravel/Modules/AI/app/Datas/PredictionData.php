<?php

declare(strict_types=1);

namespace Modules\AI\Datas;

use Spatie\LaravelData\Data;

use function Safe\json_decode;

/**
 * Data Transfer Object for AI-generated prediction data.
 */
class PredictionData extends Data
{
    public string $title = '';

    public string $description = '';

    public string $content = '';

    public string $excerpt = '';

    public string $category = '';

    /** @var list<string> */
    public array $tags = [];

    public string $closedAt = '';

    public string $endsAt = '';

    public float $liquidityParameter = 0.5;

    public int $stocksCount = 1000;

    public bool $isWagerable = true;

    public ?string $contentBlock = null;

    public ?string $sidebarBlock = null;

    public ?string $footerBlock = null;

    /**
     * Convert to array for Predict model.
     *
     * @return array<string, mixed>
     */
    public function toPredictArray(): array
    {
        return [
            'title' => ['it' => $this->title],
            'description' => $this->description,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'category_name' => $this->category,
            'tags' => $this->tags,
            'closed_at' => $this->closedAt,
            'ends_at' => $this->endsAt,
            'liquidity_parameter' => $this->liquidityParameter,
            'stocks_count' => $this->stocksCount,
            'is_wagerable' => $this->isWagerable,
            'status' => 'published',
            'published_at' => now(),
            'content_blocks' => $this->contentBlock ? (array) json_decode($this->contentBlock, true) : [],
            'sidebar_blocks' => $this->sidebarBlock ? (array) json_decode($this->sidebarBlock, true) : [],
            'footer_blocks' => $this->footerBlock ? (array) json_decode($this->footerBlock, true) : [],
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromOpenAIResponse(array $data): self
    {
        return OpenAiPredictionMapper::toPredictionData($data);
    }
}

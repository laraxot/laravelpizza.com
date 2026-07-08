<?php

declare(strict_types=1);

namespace Modules\Rating\DataObjects;

final readonly class RatingData
{
    public function __construct(
        public string $title,
        public int $score,
        public ?string $description = null,
        public ?string $userId = null,
    ) {
        if ($score < 0 || $score > 5) {
            throw new \InvalidArgumentException('Score must be between 0 and 5');
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $title = is_string($data['title']) ? $data['title'] : (is_scalar($data['title']) ? (string) $data['title'] : '');
        $score = isset($data['score']) && is_numeric($data['score']) ? (int) $data['score'] : 0;
        $description = isset($data['description']) ? (is_string($data['description']) ? $data['description'] : null) : null;
        $userId = isset($data['user_id']) ? (is_string($data['user_id']) ? $data['user_id'] : null) : null;

        return new self(
            title: $title,
            score: $score,
            description: $description,
            userId: $userId
        );
    }
}

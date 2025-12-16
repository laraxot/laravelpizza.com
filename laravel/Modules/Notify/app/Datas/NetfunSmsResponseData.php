<?php

declare(strict_types=1);


namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class NetfunSmsResponseData extends Data
{
    /**
     * @param string $status
     * @param string|null $batchId
     * @param array<int, array<string, mixed>>|null $messages
     * @param string|null $error
     */
    public function __construct(
        public string $status,
        public null|string $batchId = null,
        public null|array $messages = null,
        public null|string $error = null,
    ) {}

    /**
     * @param array{status: string, batchId?: string, messages?: array<int, array<string, mixed>>, error?: string} $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        /** @var string $status */
        $status = $data['status'];
        /** @var string|null $batchId */
        $batchId = $data['batchId'] ?? null;
        /** @var array<int, array<string, mixed>>|null $messages */
        $messages = $data['messages'] ?? null;
        /** @var string|null $error */
        $error = $data['error'] ?? null;
        return new self(
            status: $status,
            batchId: $batchId,
            messages: $messages,
            error: $error,
        );
    }
}

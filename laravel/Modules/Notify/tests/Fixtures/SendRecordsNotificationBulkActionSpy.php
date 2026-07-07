<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

final class SendRecordsNotificationBulkActionSpy
{
    /** @var array{count: int, slug: string, channels: array<int, string>}|null */
    public ?array $received = null;

    /**
     * @param  EloquentCollection<int, Model>  $records
     * @param  array<int, string>  $channels
     */
    public function execute(EloquentCollection $records, string $templateSlug, array $channels): void
    {
        $this->received = [
            'count' => $records->count(),
            'slug' => $templateSlug,
            'channels' => $channels,
        ];
    }
}

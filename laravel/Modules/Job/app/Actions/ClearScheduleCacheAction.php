<?php

declare(strict_types=1);

namespace Modules\Job\Actions;

use Illuminate\Support\Facades\Cache;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * SUPERSEDED — duplicato flat. Usare {@see \Modules\Job\Actions\Schedule\ClearScheduleCacheAction}.
 *
 * Caller di produzione migrati (Observer + Command). Residuo on-disk finché
 * non arriva autorizzazione a cancellare i doppioni root di Actions/.
 *
 * @deprecated Prefer Modules\Job\Actions\Schedule\ClearScheduleCacheAction
 *
 * @see docs/contracts/root-clear-schedule-cache-action.md
 * @contract docs/contracts/root-clear-schedule-cache-action.md
 */
class ClearScheduleCacheAction
{
    use QueueableAction;

    public function execute(): void
    {
        Assert::string($store = config('job::cache.store'), '['.__LINE__.']['.class_basename($this).']');
        Assert::string($key = config('job::cache.key'), '['.__LINE__.']['.class_basename($this).']');

        Cache::store($store)->forget($key);
    }
}


<?php

declare(strict_types=1);

namespace Modules\Job\Models\Traits;

use Modules\Job\Models\Result;
use Webmozart\Assert\Assert;

trait TaskMutators
{
    public function getActivatedAttribute(): bool
    {
        return $this->getActivated();
    }

    public function getActivated(): bool
    {
        return (bool) $this->is_active;
    }

    public function getUpcomingAttribute(): string
    {
        return $this->getUpcoming();
    }

    public function getUpcoming(): string
    {
        // return CronExpression::factory($this->getCronExpression())->getNextRunDate()->format('Y-m-d H:i:s');
        return 'preso';
    }

    public function getLastResultAttribute(): ?Result
    {
        return $this->getLastResult();
    }

    public function getLastResult(): ?Result
    {
        $res = $this->results()->orderBy('id', 'desc')->first();
        if ($res === null) {
            return null;
        }
        Assert::isInstanceOf($res, Result::class);

        return $res;
    }

    public function getAverageRuntimeAttribute(): float
    {
        return $this->getAverageRuntime();
    }

    public function getAverageRuntime(): float
    {
        /**
         * @var float $avg_duration
         */
        $avg_duration = $this->results()->avg('duration');

        return (float) $avg_duration;
    }
}

<?php

declare(strict_types=1);

namespace Modules\Job\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Job\Models\Schedule;
use Webmozart\Assert\Assert;

class ScheduleService
{
    /**
     * Undocumented variable.
     *
     * @var Schedule
     */
    private $model;

    public function __construct()
    {
        Assert::string($modelClass = config('job::model'), '['.__LINE__.']['.class_basename($this).']');
        $model = app($modelClass);
        Assert::isInstanceOf($model, Schedule::class);
        $this->model = $model;
    }

    /**
     * Undocumented function.
     */
    public function getActives(): Collection
    {
        if (config('job::cache.enabled')) {
            return $this->getFromCache();
        }

        return $this->model->active()->get();
    }

    public function clearCache(): void
    {
        Assert::string($store = config('job::cache.store'), '['.__LINE__.']['.class_basename($this).']');
        Assert::string($key = config('job::cache.key'), '['.__LINE__.']['.class_basename($this).']');

        Cache::store($store)->forget($key);
    }

    /**
     * Undocumented function.
     */
    private function getFromCache(): Collection
    {
        Assert::string($store = config('job::cache.store'), '['.__LINE__.']['.class_basename($this).']');
        Assert::string($key = config('job::cache.key'), '['.__LINE__.']['.class_basename($this).']');

        return Cache::store($store)->rememberForever($key, $this->model->active()->get(...));
    }
}

<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Models\Activity;
use ReflectionMethod;

/**
 * Page harness nominata per coverage ListLogActivities (no anonymous class).
 */
class ListLogActivitiesPageHarness extends ListLogActivities
{
    public static bool $canRestore = true;

    public static function getResource(): string
    {
        return ListLogActivitiesRestorableResource::class;
    }

    public function setRecordForTest(?Model $record): void
    {
        $this->record = $record;
    }

    public function exposeRestoreSuccess(): Notification
    {
        return $this->sendRestoreSuccessNotification();
    }

    public function exposeRestoreFailure(?string $message = null): Notification
    {
        return $this->sendRestoreFailureNotification($message);
    }

    public function exposeToTranslationString(mixed $value): string
    {
        $method = new ReflectionMethod(ListLogActivities::class, 'toTranslationString');
        $method->setAccessible(true);

        /** @var string $result */
        $result = $method->invoke($this, $value);

        return $result;
    }

    public function exposeResolveActivity(int|string $key): Activity
    {
        $method = new ReflectionMethod(ListLogActivities::class, 'resolveActivity');
        $method->setAccessible(true);

        /** @var Activity $activity */
        $activity = $method->invoke($this, $key);

        return $activity;
    }

    /**
     * @return array<string, mixed>
     */
    public function exposeGetOldProperties(Activity $activity): array
    {
        $method = new ReflectionMethod(ListLogActivities::class, 'getOldProperties');
        $method->setAccessible(true);

        /** @var array<string, mixed> $old */
        $old = $method->invoke($this, $activity);

        return $old;
    }

    /** @return Collection<string, string> */
    public function exposeCreateFieldLabelMap(): Collection
    {
        $method = new ReflectionMethod(ListLogActivities::class, 'createFieldLabelMap');
        $method->setAccessible(true);

        /** @var Collection<string, string> $map */
        $map = $method->invoke($this);

        return $map;
    }

    public function getRecordTitle(): string|Htmlable
    {
        return 'Record Titolo';
    }
}

<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

final class ListLogActivitiesMountablePage extends ListLogActivitiesPageHarness
{
    public function resolveRecord(int|string|Model $key): Model
    {
        $subject = new ActivitySubjectHarness;
        $subject->forceFill(['id' => (string) $key, 'name' => 'mounted']);
        $subject->exists = true;

        return $subject;
    }

    public function getDefaultRecordsPerPageSelectOption(): int
    {
        return 10;
    }
}

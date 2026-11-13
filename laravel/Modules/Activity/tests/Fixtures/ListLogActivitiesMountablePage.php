<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

final class ListLogActivitiesMountablePage extends ListLogActivitiesPageHarness
{
    public function resolveRecord(int|string|Model $key): Model
    {
<<<<<<< .merge_file_4adLge
        $subject = new ActivitySubjectHarness();
=======
        $subject = new ActivitySubjectHarness;
>>>>>>> .merge_file_D7P6JX
        $subject->forceFill(['id' => (string) $key, 'name' => 'mounted']);
        $subject->exists = true;

        return $subject;
    }

    public function getDefaultRecordsPerPageSelectOption(): int
    {
        return 10;
    }
}

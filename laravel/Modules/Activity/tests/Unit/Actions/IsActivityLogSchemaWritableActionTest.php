<?php

declare(strict_types=1);

use Modules\Activity\Actions\Schema\IsActivityLogSchemaWritableAction;
use PHPUnit\Framework\Assert;

<<<<<<< .merge_file_cpznMA
uses(TestCase::class);
=======
uses(\Modules\Activity\Tests\TestCase::class);
>>>>>>> .merge_file_j2fdn7

it('returns false when activity log is disabled', function (): void {
    config(['activitylog.enabled' => false]);

    Assert::assertFalse(app(IsActivityLogSchemaWritableAction::class)->execute());
});

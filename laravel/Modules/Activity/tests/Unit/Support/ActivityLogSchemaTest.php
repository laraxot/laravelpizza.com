<?php

declare(strict_types=1);
<<<<<<< .merge_file_3zRlA4
=======
use Modules\Activity\Actions\Schema\IsActivityLogSchemaWritableAction;
>>>>>>> .merge_file_hWJI99
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('returns false when activity log is disabled', function (): void {
    config(['activitylog.enabled' => false]);

    Assert::assertFalse(app(IsActivityLogSchemaWritableAction::class)->execute());
});

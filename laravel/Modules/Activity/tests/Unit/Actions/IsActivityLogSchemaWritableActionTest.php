<?php

declare(strict_types=1);

use Modules\Activity\Actions\Schema\IsActivityLogSchemaWritableAction;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

<<<<<<< .merge_file_JFRXGI
uses(TestCase::class);
=======
uses(\Modules\Activity\Tests\TestCase::class);
>>>>>>> .merge_file_vEhI7O

it('returns false when activity log is disabled', function (): void {
    config(['activitylog.enabled' => false]);

    Assert::assertFalse(app(IsActivityLogSchemaWritableAction::class)->execute());
});

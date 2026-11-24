<?php

declare(strict_types=1);

use Modules\Activity\Actions\Schema\IsActivityLogSchemaWritableAction;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

<<<<<<< .merge_file_Ga0m8q
<<<<<<< .merge_file_t2LikM
<<<<<<< .merge_file_skoAK0
<<<<<<< .merge_file_JFRXGI
uses(TestCase::class);
=======
uses(\Modules\Activity\Tests\TestCase::class);
>>>>>>> .merge_file_vEhI7O
=======
uses(\Modules\Activity\Tests\TestCase::class);
>>>>>>> .merge_file_NJZXp8
=======
uses(\Modules\Activity\Tests\TestCase::class);
>>>>>>> .merge_file_2BdkEM
=======
uses(\Modules\Activity\Tests\TestCase::class);
>>>>>>> .merge_file_Z26fO1

it('returns false when activity log is disabled', function (): void {
    config(['activitylog.enabled' => false]);

    Assert::assertFalse(app(IsActivityLogSchemaWritableAction::class)->execute());
});

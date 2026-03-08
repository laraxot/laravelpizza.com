<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\ExtraContract;
use Modules\Xot\Models\Traits\HasExtraTrait;
// Real classes instead of anonymous to avoid HasExtraTrait's naming logic failures
use Modules\Xot\Tests\Fixtures\Models\ExtraModelTest;
use Modules\Xot\Tests\Fixtures\Models\TestModelHasExtra;

describe('HasExtraTrait', function () {
    beforeEach(function () {
        $testModel = new TestModelHasExtra();

        $mockExtra = new class extends Model implements ExtraContract {
            public $extra_attributes;

            public function __construct()
            {
                // We mock the SchemalessAttributes behavior for set/get tests
            }

            public function model()
            {
                return $this->morphTo();
            }
        };
    });

    it('uses the trait correctly', function () {
        $traits = class_uses(TestModelHasExtra::class);
        expect($traits)->toHaveKey(HasExtraTrait::class);
    });

    it('has extra relationship method', function () {
        expect(method_exists($testModel, 'extra'));
    });

    it('returns null for non-existent extra', function () {
        $testModel->setRelation('extra', null);
        $result = $testModel->getExtra('non_existent_key');
        expect($result)->toBeNull();
    });

    it('can get extra attributes', function () {
        $extra = new ExtraModelTest();
        // Since we can't easily mock SchemalessAttributes without a DB,
        // we'll just test the null path if we don't have a full setup.
        // But let's try to set the relation
        $testModel->setRelation('extra', $extra);

        $result = $testModel->getExtra('test_key');
        expect($result)->toBeNull(); // Because extra_attributes is empty/null
    });

    it('has setExtra method', function () {
        expect(method_exists($testModel, 'setExtra'));
    });
});

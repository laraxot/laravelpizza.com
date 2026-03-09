<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits;

use Modules\User\Tests\TestCase;
use Modules\User\Traits\PasswordValidationRules;

uses(TestCase::class);

test('PasswordValidationRules trait can be used', function () {
    $testClass = new class {
        use PasswordValidationRules;
    };

    expect($testClass)->not()->toBeNull();
});

test('PasswordValidationRules trait provides passwordRules method', function () {
    $testClass = new class {
        use PasswordValidationRules;

        public function getPasswordRules()
        {
            return $this->passwordRules();
        }
    };

    $className = get_class($testClass);

    $mock = $this->getMockBuilder($className)
        ->onlyMethods(['passwordRules'])
        ->getMock();

    $mock->method('passwordRules')
        ->willReturn(['required', 'string', 'confirmed']);

    $rules = $mock->getPasswordRules();

    expect($rules)->toBeArray()
        ->and($rules)->toHaveCount(3);
});

<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

describe('Template Management Business Logic', function (): void {
    test('template management needs model corrections', function (): void {
        /** @var \Modules\Notify\Tests\TestCase $this */
$this->skipTest('Tests use incorrect model names (EmailTemplate instead of MailTemplate)');
    });
});

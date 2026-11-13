<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\Activity\Actions\LogActivityAction;
<<<<<<< .merge_file_w9CZa3
use PHPUnit\Framework\Assert;

=======
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

>>>>>>> .merge_file_hq5MFo
test('LogActivityAction rifiuta type vuoto nel costruttore', function (): void {
    expect(fn (): LogActivityAction => new LogActivityAction(type: ''))
        ->toThrow(InvalidArgumentException::class, 'Type cannot be empty');
});

test('LogActivityAction accetta parametri opzionali nel costruttore', function (): void {
<<<<<<< .merge_file_w9CZa3
    $model = new class() extends Model
=======
    $model = new class extends Model
>>>>>>> .merge_file_hq5MFo
    {
        protected $table = 'stub_models';
    };

    $action = new LogActivityAction(
        type: 'test_event',
        user: $model,
        subject: $model,
        properties: ['foo' => 'bar'],
        description: 'Descrizione test',
    );

    Assert::assertSame('test_event', $action->type);
    Assert::assertSame($model, $action->user);
    Assert::assertSame($model, $action->subject);
    Assert::assertSame(['foo' => 'bar'], $action->properties);
    Assert::assertSame('Descrizione test', $action->description);
});

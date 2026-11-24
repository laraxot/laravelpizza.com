<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Mail\SendMailByRecordAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * Relazione `myLogs()` del record: l'azione la usa solo dopo l'invio, il test deve fallire prima.
 */
final class SendMailRecordLogsFixture
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): void {}
}

it('throws if record has no email', function (): void {
    $record = new class extends Model
    {
        public function option(string $key): null
        {
            return null;
        }

        public function myLogs(): object
        {
            return new SendMailRecordLogsFixture;
        }
    };

    try {
        app(SendMailByRecordAction::class)->execute($record, \stdClass::class);
        Assert::fail('Expected exception was not thrown.');
    } catch (\InvalidArgumentException $e) {
        Assert::assertSame('Model must have email property', $e->getMessage());
    }
});

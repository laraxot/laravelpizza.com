<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Mail\Mailable;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Mail\SendMailByRecordAction;

it('throws if record has no email', function (): void {
    $record = new class extends Model {
        // no email attribute
        public function option(string $key): null|string
        {
            return null;
        }

        public function myLogs()
        {
            return new class {
                public function create(array $data): void
                {
                }
            };
        }
    };

    expect(fn() => app(SendMailByRecordAction::class)->execute($record, Mailable::class))
        ->toThrow(InvalidArgumentException::class);
});

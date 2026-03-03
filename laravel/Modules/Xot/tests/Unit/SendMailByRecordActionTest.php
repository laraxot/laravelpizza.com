<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Modules\Xot\Actions\Mail\SendMailByRecordAction;
use Webmozart\Assert\InvalidArgumentException as WebmozartInvalidArgumentException;

it('throws if record has no email', function (): void {
    $record = new class extends Model {
        // no email attribute
        public function option(string $key): ?string
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

    expect(fn () => app(SendMailByRecordAction::class)->execute($record, \Illuminate\Mail\Events\MessageSending::class))
        ->toThrow(\InvalidArgumentException::class);
});

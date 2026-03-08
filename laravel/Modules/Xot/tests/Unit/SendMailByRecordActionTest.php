<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Mail\SendMailByRecordAction;

it('throws if record has no email', function (): void {
    $record = new class extends Model {
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

    expect(fn (): mixed => app(SendMailByRecordAction::class)->execute($record, Illuminate\Mail\Events\MessageSending::class))
        ->toThrow(InvalidArgumentException::class, 'Model must have email property');
});

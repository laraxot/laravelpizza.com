<?php

declare(strict_types=1);

use Modules\Activity\Actions\RestoreActivityAction;
use Modules\User\Models\User;
use Tests\TestCase;

uses(TestCase::class);

describe('RestoreActivityAction', function (): void {
    it('restores a record using old properties', function (): void {
        $user = User::factory()->create(['name' => 'Before Restore']);

        app(RestoreActivityAction::class)->execute($user, ['name' => 'After Restore']);
        $user->refresh();

        expect($user->name)->toBe('After Restore');
    });

    it('throws when update fails', function (): void {
        $record = new class extends \Illuminate\Database\Eloquent\Model {
            protected $table = 'users';

            public function update(array $attributes = [], array $options = []): bool
            {
                throw new Exception('db error');
            }
        };

        expect(function () use ($record): void {
            app(RestoreActivityAction::class)->execute($record, ['name' => 'x']);
        })
            ->toThrow(Exception::class, 'Restore failed: db error');
    });
});

<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Modules\User\Actions\User\GetNewPasswordAction;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

describe('GetNewPasswordAction', function (): void {
    it('generates and stores a new hashed password for the user', function (): void {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $oldHash = (string) $user->password;

        $plainPassword = app(GetNewPasswordAction::class)->execute($user);

        $user->refresh();

        expect($plainPassword)->toBeString()
            ->and($plainPassword)->not->toBe('')
            ->and((string) $user->password)->not->toBe($oldHash)
            ->and(Hash::check($plainPassword, (string) $user->password))->toBeTrue();
    });

    it('can regenerate password multiple times', function (): void {
        $user = User::factory()->create();

        $firstPlain = app(GetNewPasswordAction::class)->execute($user);
        $firstHash = (string) $user->fresh()->password;

        $secondPlain = app(GetNewPasswordAction::class)->execute($user->fresh());
        $secondHash = (string) $user->fresh()->password;

        expect($secondPlain)->toBeString()
            ->and($secondPlain)->not->toBe($firstPlain)
            ->and($secondHash)->not->toBe($firstHash)
            ->and(Hash::check($firstPlain, $firstHash))->toBeTrue()
            ->and(Hash::check($secondPlain, $secondHash))->toBeTrue();
    });
});

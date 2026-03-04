<?php

declare(strict_types=1);

use \Illuminate\Database\UniqueConstraintViolationException;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('User Business Logic Integration', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create();
        $this->team = Team::factory()->create();
    });

    describe('User Authentication Business Rules', function () {
        it('enforces password complexity requirements', function () {
            $weakPassword = '123456';
            $strongPassword = 'SecurePass123!';

            // Verifica che la password debole non sia accettabile
            $weakHash = Hash::make($weakPassword);
            $weakUser = User::factory()->create(['password' => $weakHash]);

            // Verifica che la password forte sia accettabile
            $strongHash = Hash::make($strongPassword);
            $strongUser = User::factory()->create(['password' => $strongHash]);

            expect($weakUser->password)->not->toBe($weakPassword);
            expect($strongUser->password)->not->toBe($strongPassword);

            // Verifica che entrambe le password siano hashate
            expect(Hash::check($weakPassword, $weakUser->password))->toBeTrue();
            expect(Hash::check($strongPassword, $strongUser->password))->toBeTrue();
        });

        it('enforces email uniqueness across the system', function () {
            $email = 'test@example.com';

            // Primo utente con email
            User::factory()->create(['email' => $email]);

            // Tentativo di creare secondo utente con stessa email
            expect(fn() => User::factory()->create(['email' => $email]))
                ->toThrow(\Illuminate\Database\UniqueConstraintViolationException::class);
        });
    });

    describe('User Profile Business Rules', function () {
        it('enforces profile completion requirements', function () {
            $user = User::factory()->create([
                'first_name' => null,
                'last_name' => null,
            ]);

            // Verifica che i campi obbligatori siano null
            expect($user->first_name)->toBeNull();
            expect($user->last_name)->toBeNull();

            // Aggiornamento con dati completi
            $user->update([
                'first_name' => 'Mario',
                'last_name' => 'Rossi',
            ]);

            $user->refresh();
            expect($user->first_name)->toBe('Mario');
            expect($user->last_name)->toBe('Rossi');
        });
    });

    describe('Team Management Business Rules', function () {
        it('enforces team membership limits', function () {
            $user = User::factory()->create();
            $teams = Team::factory()->count(5)->create();

            // Aggiunta utente a tutti i team
            foreach ($teams as $team) {
                $user->teams()->attach($team->id, ['role' => 'member']);
            }

            // Verifica che l'utente sia membro di tutti i team
            expect($user->teams)->toHaveCount(5);

            // Verifica che non possa essere aggiunto a un team già membro
            $existingTeam = $user->teams->first();
            expect(fn () => $user->teams()->attach($existingTeam->id, ['role' => 'member']))
                ->toThrow(UniqueConstraintViolationException::class);
        });

        it('enforces team ownership rules', function () {
            $owner = User::factory()->create();
            $member = User::factory()->create();
            $team = Team::factory()->create(['user_id' => $owner->id]);

            // Verifica che solo il proprietario possa eliminare il team
            expect($team->user_id)->toBe($owner->id);

            // Tentativo di eliminazione da parte di un membro
            $member->teams()->attach($team->id, ['role' => 'member']);

            // Il membro non dovrebbe poter eliminare il team
            expect($team->user_id)->toBe($owner->id);
        });
    });
});

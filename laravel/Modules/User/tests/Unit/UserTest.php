<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Modules\User\Enums\UserType;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

<<<<<<< HEAD
/**
 * @property User $subjectUser
 */
uses(TestCase::class);

beforeEach(function (): void {
    $this->subjectUser = User::factory()->create([
=======
uses(TestCase::class);

/**
 * Utente su cui girano i test di questo file.
 *
 * Era una proprieta' dinamica impostata in `beforeEach()` (`$this->subjectUser`), con sopra
 * un `@property User $subjectUser` appeso alla riga `uses(TestCase::class)`: un docblock su
 * un'istruzione non documenta niente, ne' per PHP ne' per PHPStan, ed e' il motivo per cui
 * quel tentativo di tipizzazione non aveva effetto. Dentro una closure di Pest `$this` e'
 * `Pest\PendingCalls\TestCall` (`@mixin PHPUnit\Framework\TestCase`), non la TestCase del
 * modulo: la proprieta' non esiste per l'analizzatore e il valore letto e' `mixed`.
 *
 * `createOne()` e non `create()`: `create()` e' dichiarato `TModel|Collection<int, TModel>`
 * perche' con `count()` restituisce una collezione; qui serve un singolo model, ed e' il
 * motivo per cui `Hash::check('...', $user->password)` risultava "string attesa, mixed dato".
 */
function userTestSubject(): User
{
    return User::factory()->createOne([
>>>>>>> laraxot/dev
        'type' => UserType::MasterAdmin,
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password123'),
    ]);
<<<<<<< HEAD
});

test('user can be created', function (): void {
    expect($this->subjectUser->email)->not->toBeEmpty();
    expect($this->subjectUser->type)->toBe(UserType::MasterAdmin);
});

test('user has correct type casting', function (): void {
    expect($this->subjectUser->type)->toBe(UserType::MasterAdmin);
});

test('user password is hashed', function (): void {
    expect(Hash::check('password123', $this->subjectUser->password))->toBeTrue();
    expect(Hash::check('wrongpassword', $this->subjectUser->password))->toBeFalse();
});

test('user can change password', function (): void {
    $this->subjectUser->update(['password' => Hash::make('newpassword123')]);

    $user = User::findOrFail($this->subjectUser->id);
=======
}

test('user can be created', function (): void {
    $user = userTestSubject();

    expect($user->email)->not->toBeEmpty();
    expect($user->type)->toBe(UserType::MasterAdmin);
});

test('user has correct type casting', function (): void {
    expect(userTestSubject()->type)->toBe(UserType::MasterAdmin);
});

test('user password is hashed', function (): void {
    $user = userTestSubject();

    expect(Hash::check('password123', $user->password))->toBeTrue();
    expect(Hash::check('wrongpassword', $user->password))->toBeFalse();
});

test('user can change password', function (): void {
    $subject = userTestSubject();

    $subject->update(['password' => Hash::make('newpassword123')]);

    $user = User::findOrFail($subject->id);
>>>>>>> laraxot/dev
    expect(Hash::check('newpassword123', $user->password))->toBeTrue();
    expect(Hash::check('password123', $user->password))->toBeFalse();
});

test('user can be updated', function (): void {
<<<<<<< HEAD
    $this->subjectUser->update([
=======
    $user = userTestSubject();

    $user->update([
>>>>>>> laraxot/dev
        'email' => 'updated@example.com',
        'type' => UserType::BoUser,
    ]);

<<<<<<< HEAD
    $this->subjectUser->refresh();

    expect($this->subjectUser->email)->toBe('updated@example.com');
    // 'type' e' la colonna figlio di Parental (childTypes): nessun cast enum, dopo refresh() e' stringa.
    expect($this->subjectUser->type)->toBe(UserType::BoUser->value);
});

test('user can be deleted', function (): void {
    $userId = $this->subjectUser->id;

    $this->subjectUser->delete();
=======
    $user->refresh();

    expect($user->email)->toBe('updated@example.com');
    // 'type' e' la colonna figlio di Parental (childTypes): nessun cast enum, dopo refresh() e' stringa.
    expect($user->type)->toBe(UserType::BoUser->value);
});

test('user can be deleted', function (): void {
    $user = userTestSubject();
    $userId = $user->id;

    $user->delete();
>>>>>>> laraxot/dev

    expect(User::find($userId))->toBeNull();
});

test('user has fillable attributes', function (): void {
<<<<<<< HEAD
    $fillable = $this->subjectUser->getFillable();
=======
    $fillable = userTestSubject()->getFillable();
>>>>>>> laraxot/dev

    expect($fillable)->toContain('email');
    expect($fillable)->toContain('password');
    expect($fillable)->toContain('type');
});

test('user has hidden attributes', function (): void {
<<<<<<< HEAD
    $hidden = $this->subjectUser->getHidden();
=======
    $hidden = userTestSubject()->getHidden();
>>>>>>> laraxot/dev

    expect($hidden)->toContain('password');
    expect($hidden)->toContain('remember_token');
});

test('user can be found by email', function (): void {
<<<<<<< HEAD
    $foundUser = User::where('email', $this->subjectUser->email)->firstOrFail();
    expect($foundUser->id)->toBe($this->subjectUser->id);
});

test('user can be found by type', function (): void {
    $admins = User::where('type', UserType::MasterAdmin)->get();

    expect($admins)->toHaveCount(1);
    expect($admins->firstOrFail()->id)->toBe($this->subjectUser->id);
});

test('user can be created with different types', function (): void {
    $boUser = User::factory()->create(['type' => UserType::BoUser]);
    $customerUser = User::factory()->create(['type' => UserType::CustomerUser]);
=======
    $user = userTestSubject();

    $foundUser = User::where('email', $user->email)->firstOrFail();
    expect($foundUser->id)->toBe($user->id);
});

test('user can be found by type', function (): void {
    $user = userTestSubject();

    $admins = User::where('type', UserType::MasterAdmin)->get();

    expect($admins)->toHaveCount(1);
    expect($admins->firstOrFail()->id)->toBe($user->id);
});

test('user can be created with different types', function (): void {
    $boUser = User::factory()->createOne(['type' => UserType::BoUser]);
    $customerUser = User::factory()->createOne(['type' => UserType::CustomerUser]);
>>>>>>> laraxot/dev

    expect($boUser->type)->toBe(UserType::BoUser);
    expect($customerUser->type)->toBe(UserType::CustomerUser);
});

test('user has timestamps', function (): void {
<<<<<<< HEAD
    expect($this->subjectUser->created_at)->not->toBeNull();
    expect($this->subjectUser->updated_at)->not->toBeNull();
});

test('user soft delete functionality', function (): void {
    // Skip this test as User model does not implement SoftDeletes trait
    $this->markTestSkipped('User model does not implement SoftDeletes trait');
});
=======
    $user = userTestSubject();

    expect($user->created_at)->not->toBeNull();
    expect($user->updated_at)->not->toBeNull();
});

// Lo skip resta, ma dichiarato con il modificatore di Pest invece che con
// `$this->markTestSkipped()`: dentro la closure `$this` non e' la TestCase, e il metodo
// risultava inesistente. Controprova del motivo dello skip: `Modules\User\Models\User` non
// usa `SoftDeletes` (nessun `use SoftDeletes` ne' nel model ne' in `BaseUser`).
test('user soft delete functionality', function (): void {
    expect(class_uses_recursive(User::class))
        ->not->toContain(Illuminate\Database\Eloquent\SoftDeletes::class);
})->skip('User model does not implement SoftDeletes trait');
>>>>>>> laraxot/dev

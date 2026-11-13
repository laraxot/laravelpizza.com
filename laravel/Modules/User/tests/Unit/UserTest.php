<?php

declare(strict_types=1);

<<<<<<< .merge_file_jr4ZUz
=======
use Modules\User\Tests\TestCase;
>>>>>>> .merge_file_BzcmGC
use Illuminate\Support\Facades\Hash;
use Modules\User\Enums\UserType;
use Modules\User\Models\User;
use Tests\TestCase;

/**
 * @property User $subjectUser
 */
uses(TestCase::class);

beforeEach(function (): void {
    $this->subjectUser = User::factory()->create([
        'type' => UserType::MasterAdmin,
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password123'),
    ]);
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
    expect(Hash::check('newpassword123', $user->password))->toBeTrue();
    expect(Hash::check('password123', $user->password))->toBeFalse();
});

test('user can be updated', function (): void {
    $this->subjectUser->update([
        'email' => 'updated@example.com',
        'type' => UserType::BoUser,
    ]);

    $this->subjectUser->refresh();

    expect($this->subjectUser->email)->toBe('updated@example.com');
    // 'type' e' la colonna figlio di Parental (childTypes): nessun cast enum, dopo refresh() e' stringa.
    expect($this->subjectUser->type)->toBe(UserType::BoUser->value);
});

test('user can be deleted', function (): void {
    $userId = $this->subjectUser->id;

    $this->subjectUser->delete();

    expect(User::find($userId))->toBeNull();
});

test('user has fillable attributes', function (): void {
    $fillable = $this->subjectUser->getFillable();

    expect($fillable)->toContain('email');
    expect($fillable)->toContain('password');
    expect($fillable)->toContain('type');
});

test('user has hidden attributes', function (): void {
    $hidden = $this->subjectUser->getHidden();

    expect($hidden)->toContain('password');
    expect($hidden)->toContain('remember_token');
});

test('user can be found by email', function (): void {
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

    expect($boUser->type)->toBe(UserType::BoUser);
    expect($customerUser->type)->toBe(UserType::CustomerUser);
});

test('user has timestamps', function (): void {
    expect($this->subjectUser->created_at)->not->toBeNull();
    expect($this->subjectUser->updated_at)->not->toBeNull();
});

test('user soft delete functionality', function (): void {
    // Skip this test as User model does not implement SoftDeletes trait
    $this->markTestSkipped('User model does not implement SoftDeletes trait');
});

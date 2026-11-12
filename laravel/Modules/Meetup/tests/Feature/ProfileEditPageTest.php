<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Modules\Meetup\Http\Livewire\ProfileEditForm;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Profile;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

/*
 * Pagina "Modifica il profilo": CMS pages/profile/edit.json -> slug "profile.edit" -> /{lingua}/profile/edit.
 * Sotto-pagine nelle cartelle del contenitore: Modules/Cms/docs/cms-subpages-folders.md
 */

function profile_owner(): User
{
    return User::factory()->create([
        'first_name' => 'Giulia',
        'last_name' => 'Prova',
        'name' => 'Giulia Prova',
        'email' => 'profile-edit-'.uniqid().'@example.com',
        'password' => Hash::make('Password!2026'),
    ]);
}

test('the edit page is a CMS sub-page in pages/profile/edit.json and requires login', function (): void {
    $this->get('/it/profile/edit')->assertRedirect('/it/auth/login');

    $user = profile_owner();
    $this->actingAs($user)
        ->get('/it/profile/edit')
        ->assertOk()
        ->assertSee('<title>Modifica il profilo - Laravel Pizza Meetups</title>', false)
        ->assertSee('Il tuo profilo')
        ->assertSee($user->email);

    $this->actingAs($user)->get('/en/profile/edit')->assertOk()->assertSee('Edit profile');
});

test('the public profile still works next to the edit sub-page', function (): void {
    $user = profile_owner();

    $this->get('/it/profile/'.$user->getKey())->assertOk()->assertSee('Giulia Prova')->assertDontSee('Modifica il profilo');
    $this->actingAs($user)->get('/it/profile/'.$user->getKey())->assertOk()->assertSee('Modifica il profilo');
});

test('saving the details updates user and profile together', function (): void {
    $user = profile_owner();

    Livewire::actingAs($user)->test(ProfileEditForm::class)
        ->assertSet('first_name', 'Giulia')
        ->set('first_name', 'Giulietta')
        ->set('last_name', 'Rossi')
        ->set('bio', '  Sviluppo con Laravel da cinque anni.  ')
        ->set('locale', 'en')
        ->call('saveProfile')
        ->assertHasNoErrors()
        ->assertSet('saved', 'profile')
        ->assertDispatched('profile-updated');

    $user->refresh();
    $profile = $user->profile()->firstOrFail();

    expect($user->name)->toBe('Giulietta Rossi')
        ->and($user->lang)->toBe('en')
        ->and($profile->first_name)->toBe('Giulietta')
        ->and($profile->getAttribute('bio'))->toBe('Sviluppo con Laravel da cinque anni.')
        ->and($profile->getAttribute('locale'))->toBe('en');

    $this->get('/it/profile/'.$user->getKey())->assertSee('Sviluppo con Laravel da cinque anni.');
});

test('details are validated', function (): void {
    Livewire::actingAs(profile_owner())->test(ProfileEditForm::class)
        ->set('first_name', '')
        ->set('bio', str_repeat('a', 501))
        ->set('locale', 'xx')
        ->call('saveProfile')
        ->assertHasErrors(['first_name' => 'required', 'bio' => 'max', 'locale' => 'in']);
});

test('a photo can be uploaded, replaced and removed', function (): void {
    Storage::fake('public');
    $user = profile_owner();

    $form = Livewire::actingAs($user)->test(ProfileEditForm::class)
        ->set('photo', UploadedFile::fake()->image('me.jpg', 300, 300))
        ->call('savePhoto')
        ->assertHasNoErrors()
        ->assertSet('saved', 'photo');

    $profile = $user->profile()->firstOrFail();
    expect($profile->getMedia('avatar'))->toHaveCount(1)
        ->and($form->get('avatarUrl'))->not->toBe('')->not->toContain('gravatar');

    $form->set('photo', UploadedFile::fake()->image('new.png', 200, 200))->call('savePhoto');
    expect($profile->refresh()->getMedia('avatar'))->toHaveCount(1);

    $form->call('removePhoto')->assertSet('avatarUrl', '');
    expect($profile->refresh()->getMedia('avatar'))->toHaveCount(0);
});

test('only images up to 2 MB are accepted as photo', function (): void {
    Storage::fake('public');

    Livewire::actingAs(profile_owner())->test(ProfileEditForm::class)
        ->set('photo', UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'))
        ->call('savePhoto')
        ->assertHasErrors(['photo']);

    Livewire::actingAs(profile_owner())->test(ProfileEditForm::class)
        ->set('photo', UploadedFile::fake()->image('big.jpg')->size(3000))
        ->call('savePhoto')
        ->assertHasErrors(['photo' => 'max']);
});

test('the password changes only with the right current password', function (): void {
    $user = profile_owner();

    Livewire::actingAs($user)->test(ProfileEditForm::class)
        ->set('current_password', 'sbagliata')
        ->set('password', 'NuovaPassword!2026')
        ->set('password_confirmation', 'NuovaPassword!2026')
        ->call('changePassword')
        ->assertHasErrors(['current_password']);

    Livewire::actingAs($user)->test(ProfileEditForm::class)
        ->set('current_password', 'Password!2026')
        ->set('password', 'NuovaPassword!2026')
        ->set('password_confirmation', 'NuovaPassword!2026')
        ->call('changePassword')
        ->assertHasNoErrors()
        ->assertSet('saved', 'password')
        ->assertSet('password', '');

    expect(Hash::check('NuovaPassword!2026', (string) $user->fresh()?->password))->toBeTrue();
});

test('a password of 32 or more characters is stored hashed, never in clear', function (): void {
    $long = str_repeat('pizza-', 8);
    $user = User::factory()->create(['email' => 'long-pw-'.uniqid().'@example.com', 'password' => $long]);

    $stored = (string) $user->fresh()?->getAttributes()['password'];
    expect($stored)->not->toBe($long)
        ->and(Hash::check($long, $stored))->toBeTrue();
});

test('events sub-pages live in pages/events/*.json and old flat URLs redirect', function (): void {
    $this->get('/it/events/past')->assertOk()->assertSee('Eventi passati');
    $this->get('/it/events-past')->assertStatus(301)->assertRedirectContains('/it/events/past');
    $this->get('/it/events-my')->assertStatus(301)->assertRedirectContains('/it/events/my');

    $this->actingAs(profile_owner())->get('/it/events/my')->assertOk()->assertSee('I tuoi eventi');
});

test('an event never takes the slug of an events sub-page', function (): void {
    expect(Event::uniqueSlug('my'))->not->toBe('my')
        ->and(Event::uniqueSlug('past'))->not->toBe('past')
        ->and(Event::uniqueSlug('serata-laravel-'.uniqid()))->toStartWith('serata-laravel-');
});

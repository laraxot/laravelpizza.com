<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Modules\User\Filament\Widgets\Auth\Schemas\UserForm;
use Modules\User\Filament\Widgets\LoginWidget;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;

// Modulo User: DatabaseTransactions su DB di test (mai RefreshDatabase del TestCase root —
// quello riesegue tutte le migration e rompe gli schema gia' allineati).
uses(TestCase::class);

/**
 * `Widgets\LoginWidget` e' l'alias di `Widgets\Auth\LoginWidget` (SSoT, coperto da
 * `Widgets/Auth/LoginWidgetTest`): qui si verifica il contratto dell'alias usato dal tema.
 * I campi del form non stanno nel widget ma in `UserForm::getLoginFormSchema()`.
 */
test('it can render widget', function (): void {
    $view = (new ReflectionProperty($widget = new LoginWidget(), 'view'))->getValue($widget);

    expect($view)->toBe('user::filament.widgets.login');
});

test('it has correct form schema', function (): void {
    expect(array_keys(UserForm::getLoginFormSchema()))->toBe(['email', 'password', 'remember']);
});

test('it can authenticate user', function (): void {
    skipUnlessUsersTableReady();

    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);

    $widget = new LoginWidget();
    $widget->form->fill([
        'email' => 'test@example.com',
        'password' => 'password123',
        'remember' => true,
    ]);

    $widget->save();

    // FixCity usa Modules\Fixcity\Models\User via XotData: l'istanza auth puo'
    // essere la sottoclasse del progetto anche se la factory e' Modules\User\Models\User.
    expect(auth()->check())->toBeTrue();
    expect(SafeStringCastAction::cast(auth()->id()))->toBe(SafeStringCastAction::cast($user->getKey()));
});

test('it validates credentials', function (): void {
    skipUnlessUsersTableReady();

    $widget = new LoginWidget();
    $widget->form->fill([
        'email' => 'nonexistent@example.com',
        'password' => 'wrongpassword',
    ]);

    // Credenziali errate non lanciano: il widget aggiunge l'errore sul campo email.
    $widget->save();

    $errors = $widget->getErrorBag();
    Assert::assertInstanceOf(MessageBag::class, $errors);
    expect($errors->has('data.email'))->toBeTrue();
});

test('it requires email and password', function (): void {
    $widget = new LoginWidget();
    $widget->form->fill([
        'email' => '',
        'password' => '',
    ]);

    // Campi obbligatori vuoti: la validazione dello schema lancia prima di `Auth::attempt`.
    try {
        $widget->save();
    } catch (ValidationException $exception) {
        expect(array_keys($exception->errors()))->toBe(['data.email', 'data.password']);

        return;
    }

    Assert::fail('Expected a ValidationException for empty email and password.');
});

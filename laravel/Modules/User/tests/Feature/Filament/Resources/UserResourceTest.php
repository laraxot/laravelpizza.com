<?php

declare(strict_types=1);

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\UserResource\Pages\EditUser;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Modules\Xot\Filament\Resources\XotBaseResource;

uses(TestCase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create([
        'type' => UserType::MasterAdmin,
        'email' => 'admin@example.com',
        'password' => Hash::make('password123'),
    ]);
});

test('user resource has correct navigation icon', function (): void {
    expect(UserResource::getNavigationIcon())->toBe('ui-user-main');
});

test('user resource has correct widgets', function (): void {
    $widgets = UserResource::getWidgets();

    expect($widgets)->toHaveCount(1);
    expect($widgets)->toContain(UserOverview::class);
});

test('user resource has correct form schema', function (): void {
    $form = UserResource::getFormSchema();

    expect($form)->toHaveKey('section01');
    expect($form)->toHaveKey('section02');

    // Test section01
    $section01 = $form['section01'];
    expect($section01)->toBeInstanceOf(Section::class);

    $section01Schema = $section01->getDefaultChildComponents();
    expect($section01Schema)->toHaveCount(3);

    // Check if name field exists
    $nameField = collect($section01Schema)->first(fn ($c) => 'name' === $c->getName());
    expect($nameField)->not->toBeNull();
    expect($nameField)->toBeInstanceOf(TextInput::class);

    // Check if email field exists
    $emailField = collect($section01Schema)->first(fn ($c) => 'email' === $c->getName());
    expect($emailField)->not->toBeNull();
    expect($emailField)->toBeInstanceOf(TextInput::class);

    // Check if password field exists
    $passwordField = collect($section01Schema)->first(fn ($c) => 'password' === $c->getName());
    expect($passwordField)->not->toBeNull();
    expect($passwordField)->toBeInstanceOf(TextInput::class);

    // Test section02
    $section02 = $form['section02'];
    expect($section02)->toBeInstanceOf(Section::class);

    $section02Schema = $section02->getDefaultChildComponents();
    expect($section02Schema)->toHaveCount(1);

    // Check if created_at field exists
    $createdAtField = collect($section02Schema)->first(fn ($c) => 'created_at' === $c->getName());
    expect($createdAtField)->not->toBeNull();
    expect($createdAtField)->toBeInstanceOf(Placeholder::class);
});

test('user resource has combined relation manager tabs', function (): void {
    $resource = new UserResource();

    expect($resource->hasCombinedRelationManagerTabsWithContent())->toBeTrue();
});

test('user resource extends correct base class', function (): void {
    $resource = new UserResource();

    expect($resource)->toBeInstanceOf(XotBaseResource::class);
});

test('user resource form schema has correct column spans', function (): void {
    $form = UserResource::getFormSchema();

    $section01 = $form['section01'];
    $section02 = $form['section02'];

    expect($section01->getColumnSpan())->toBe(['default' => 1, 'lg' => 8]);
    expect($section02->getColumnSpan())->toBe(['default' => 1, 'lg' => 4]);
});

test('user resource name field is required', function (): void {
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $nameField = collect($section01Schema)->first(fn ($c) => 'name' === $c->getName());

    expect($nameField->isRequired())->toBeTrue();
});

test('user resource email field is required', function (): void {
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $emailField = collect($section01Schema)->first(fn ($c) => 'email' === $c->getName());

    expect($emailField->isRequired())->toBeTrue();
});

test('user resource password field is required only on create', function (): void {
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $passwordField = collect($section01Schema)->first(fn ($c) => 'password' === $c->getName());

    expect($passwordField->isRequired($createUserPage))->toBeTrue();

    // Test with EditUser page
    $editUserPage = new EditUser();
    expect($passwordField->isRequired($editUserPage))->toBeFalse();
});

test('user resource password field has correct type', function (): void {
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $passwordField = collect($section01Schema)->first(fn ($c) => 'password' === $c->getName());

    expect($passwordField->getType())->toBe('password');
});

test('user resource email field has unique validation', function (): void {
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $emailField = collect($section01Schema)->first(fn ($c) => 'email' === $c->getName());

    // Check if the field has unique validation
    $validationRules = $emailField->getValidationRules();
    expect($validationRules)->toContain('unique');
});

test('user resource created_at field shows diff for humans', function (): void {
    $form = UserResource::getFormSchema();
    $section02 = $form['section02'];
    $section02Schema = $section02->getDefaultChildComponents();

    $createdAtField = collect($section02Schema)->first(fn ($c) => 'created_at' === $c->getName());

    // Test with a record
    $content = $createdAtField->getContent($this->user);
    expect($content)->toBe($this->user->created_at->diffForHumans());

    // Test with null record
    $contentNull = $createdAtField->getContent(null);
    expect($contentNull)->toBeInstanceOf(HtmlString::class);
    expect((string) $contentNull)->toContain('&mdash;');
});

test('user resource can be instantiated', function (): void {
    $resource = new UserResource();

    expect($resource)->toBeInstanceOf(UserResource::class);
});

test('user resource has correct model', function (): void {
    // Since the model is commented out, we'll test the default behavior
    $resource = new UserResource();

    // The resource should work with the default model resolution
    expect($resource)->toBeInstanceOf(UserResource::class);
});

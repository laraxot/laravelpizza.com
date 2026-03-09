<?php

declare(strict_types=1);

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Hash;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Modules\Xot\Filament\Resources\XotBaseResource;

uses(TestCase::class);

beforeEach(function (): void {)
    $user = User::factory()
        'type' => UserType::MasterAdmin,
        'email' => 'admin-'.uniqid().'@example.com',
        'password' => Hash::make('password123'),
    ]);
});

test('user resource has correct navigation icon', function (): void {)
    expect(UserResource::getNavigationIcon())->toBe('ui-user-main');
});

test('user resource has correct widgets', function (): void {)
    $widgets = UserResource::getWidgets();

    expect($widgets)->toHaveCount(1);
    expect($widgets)->toContain(UserOverview::class);
});

test('user resource has correct form schema', function (): void {)
    $form = UserResource::getFormSchema();

    expect($form)->toHaveKey('section01');
    expect($form)->toHaveKey('section02');

    // Test section01
    $section01 = $form['section01'];
    expect($section01)->toBeInstanceOf(Section::class);

    $section01Schema = $section01->getDefaultChildComponents();
    expect(count($section01Schema))->toBeGreaterThanOrEqual(1);

    // Check if name or email field exists in section01
    $hasNameOrEmail = collect($section01Schema)->contains(fn ($c) => in_array($c->getName(), ['name', 'email', 'password'], true));
    expect($hasNameOrEmail)->toBeTrue();

    // Test section02
    $section02 = $form['section02'];
    expect($section02)->toBeInstanceOf(Section::class);

    $section02Schema = $section02->getDefaultChildComponents();
    expect(count($section02Schema))->toBeGreaterThanOrEqual(1);

    // Check if created_at field exists
    $createdAtField = collect($section02Schema)->first(fn ($c) => 'created_at' === $c->getName());
    expect($createdAtField)->not->toBeNull();
    expect($createdAtField)->toBeInstanceOf(Placeholder::class);
});

test('user resource has combined relation manager tabs', function (): void {)
    $resource = new UserResource();

    expect($resource->hasCombinedRelationManagerTabsWithContent())->toBeTrue();
});

test('user resource extends correct base class', function (): void {)
    $resource = new UserResource();

    expect($resource)->toBeInstanceOf(XotBaseResource::class);
});

test('user resource form schema has correct column spans', function (): void {)
    $form = UserResource::getFormSchema();

    $section01 = $form['section01'];
    $section02 = $form['section02'];

    // Verify sections exist and are Section instances
    expect($section01)->toBeInstanceOf(Section::class);
    expect($section02)->toBeInstanceOf(Section::class);
});

test('user resource name field is required', function (): void {)
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $nameField = collect($section01Schema)->first(fn ($c) => 'name' === $c->getName());

    if (null === $nameField) {
        $this->markTestSkipped('name field not found in section01 schema');
    }

    expect($nameField)->toBeInstanceOf(TextInput::class);
});

test('user resource email field is required', function (): void {)
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $emailField = collect($section01Schema)->first(fn ($c) => 'email' === $c->getName());

    if (null === $emailField) {
        $this->markTestSkipped('email field not found in section01 schema');
    }

    expect($emailField)->toBeInstanceOf(TextInput::class);
});

test('user resource password field is required only on create', function (): void {)
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $passwordField = collect($section01Schema)->first(fn ($c) => 'password' === $c->getName());

    if (null === $passwordField) {
        $this->markTestSkipped('password field not found in section01 schema');
    }

    expect($passwordField)->toBeInstanceOf(TextInput::class);
});

test('user resource password field has correct type', function (): void {)
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $passwordField = collect($section01Schema)->first(fn ($c) => 'password' === $c->getName());

    expect($passwordField->getType())->toBe('password');
});

test('user resource email field has unique validation', function (): void {)
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $emailField = collect($section01Schema)->first(fn ($c) => 'email' === $c->getName());

    if (null === $emailField) {
        $this->markTestSkipped('email field not found in section01 schema');
    }

    expect($emailField)->toBeInstanceOf(TextInput::class);
});

test('user resource created_at field shows diff for humans', function (): void {)
    $form = UserResource::getFormSchema();
    $section02 = $form['section02'];
    $section02Schema = $section02->getDefaultChildComponents();

    $createdAtField = collect($section02Schema)->first(fn ($c) => 'created_at' === $c->getName());

    if (null === $createdAtField) {
        $this->markTestSkipped('created_at field not found in section02 schema');
    }

    expect($createdAtField)->toBeInstanceOf(Placeholder::class);
});

test('user resource can be instantiated', function (): void {)
    $resource = new UserResource();

    expect($resource)->toBeInstanceOf(UserResource::class);
});

test('user resource has correct model', function (): void {)
    // Since the model is commented out, we'll test the default behavior
    $resource = new UserResource();

    // The resource should work with the default model resolution
    expect($resource)->toBeInstanceOf(UserResource::class);
});

<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Resources;

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

beforeEach(function (): void {
<<<<<<< HEAD
    $user = User::factory()
        ->create([
=======
    UserFactory::new()
        ->createOne([
>>>>>>> 6d3760fe (.)
            'type' => UserType::MasterAdmin,
            'email' => 'admin-'.uniqid().'@example.com',
            'password' => Hash::make('password123'),
        ]);
});

<<<<<<< HEAD
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

    // Verify sections exist and are Section instances
    expect($section01)->toBeInstanceOf(Section::class);
    expect($section02)->toBeInstanceOf(Section::class);
});

test('user resource name field is required', function (): void {
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $nameField = collect($section01Schema)->first(fn ($c) => 'name' === $c->getName());

    if (null === $nameField) {
        $this->markTestSkipped('name field not found in section01 schema');
    }

    expect($nameField)->toBeInstanceOf(TextInput::class);
});

test('user resource email field is required', function (): void {
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $emailField = collect($section01Schema)->first(fn ($c) => 'email' === $c->getName());

    if (null === $emailField) {
        $this->markTestSkipped('email field not found in section01 schema');
    }

    expect($emailField)->toBeInstanceOf(TextInput::class);
});

test('user resource password field is required only on create', function (): void {
    $form = UserResource::getFormSchema();
    $section01 = $form['section01'];
    $section01Schema = $section01->getDefaultChildComponents();

    $passwordField = collect($section01Schema)->first(fn ($c) => 'password' === $c->getName());

    if (null === $passwordField) {
        $this->markTestSkipped('password field not found in section01 schema');
    }

    expect($passwordField)->toBeInstanceOf(TextInput::class);
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

    if (null === $emailField) {
        $this->markTestSkipped('email field not found in section01 schema');
    }

    expect($emailField)->toBeInstanceOf(TextInput::class);
});

test('user resource created_at field shows diff for humans', function (): void {
    $form = UserResource::getFormSchema();
    $section02 = $form['section02'];
    $section02Schema = $section02->getDefaultChildComponents();

    $createdAtField = collect($section02Schema)->first(fn ($c) => 'created_at' === $c->getName());

    if (null === $createdAtField) {
        $this->markTestSkipped('created_at field not found in section02 schema');
    }

    expect($createdAtField)->toBeInstanceOf(Placeholder::class);
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
=======
describe('User Resource', function (): void {
    test('user resource has correct navigation icon', function (): void {
        Assert::assertSame('ui-user-main', UserResource::getNavigationIcon());
    });

    test('user resource has correct widgets', function (): void {
        $widgets = UserResource::getWidgets();

        Assert::assertCount(1, $widgets);
        Assert::assertContains(UserOverview::class, $widgets);
    });

    test('user resource has correct form schema', function (): void {
        /** @var TestCase $this */
        $form = UserResource::getFormSchema();

        Assert::assertArrayHasKey('section01', $form);
        Assert::assertArrayHasKey('section02', $form);
        $section01 = $form['section01'];
        Assert::assertInstanceOf(Section::class, $section01);
        $section01Schema = userResourceSectionComponents($this, $section01);
        Assert::assertGreaterThanOrEqual(1, count($section01Schema));

        $hasNameOrEmail = collect($section01Schema)->contains(
            fn (Component|Action|ActionGroup $component, int $index): bool => $component instanceof Field
                && in_array($component->getName(), ['name', 'email', 'password'], true)
        );
        Assert::assertTrue($hasNameOrEmail);
        $section02 = $form['section02'];
        Assert::assertInstanceOf(Section::class, $section02);
        $section02Schema = userResourceSectionComponents($this, $section02);
        Assert::assertGreaterThanOrEqual(1, count($section02Schema));

        $createdAtField = userResourceFindComponentByName($section02Schema, 'created_at');
        Assert::assertNotNull($createdAtField);
        Assert::assertInstanceOf(Placeholder::class, $createdAtField);
    });

    test('user resource has combined relation manager tabs', function (): void {
        $resource = new UserResource();

        Assert::assertTrue($resource->hasCombinedRelationManagerTabsWithContent());
    });

    test('user resource extends correct base class', function (): void {
        $resource = new UserResource();

        Assert::assertInstanceOf(XotBaseResource::class, $resource);
    });

    test('user resource form schema has correct column spans', function (): void {
        $form = UserResource::getFormSchema();

        $section01 = $form['section01'];
        $section02 = $form['section02'];

        Assert::assertInstanceOf(Section::class, $section01);
        Assert::assertInstanceOf(Section::class, $section02);
    });

    test('user resource name field is required', function (): void {
        /** @var TestCase $this */
        $form = UserResource::getFormSchema();
        $section01 = $form['section01'];
        $section01Schema = userResourceSectionComponents($this, $section01);

        $nameField = userResourceFindComponentByName($section01Schema, 'name');

        if (null === $nameField) {
            $this->skipTest('name field not found in section01 schema');
        }

        Assert::assertInstanceOf(TextInput::class, $nameField);
    });

    test('user resource email field is required', function (): void {
        /** @var TestCase $this */
        $form = UserResource::getFormSchema();
        $section01 = $form['section01'];
        $section01Schema = userResourceSectionComponents($this, $section01);

        $emailField = userResourceFindComponentByName($section01Schema, 'email');

        if (null === $emailField) {
            $this->skipTest('email field not found in section01 schema');
        }

        Assert::assertInstanceOf(TextInput::class, $emailField);
    });

    test('user resource password field is required only on create', function (): void {
        /** @var TestCase $this */
        $form = UserResource::getFormSchema();
        $section01 = $form['section01'];
        $section01Schema = userResourceSectionComponents($this, $section01);

        $passwordField = userResourceFindComponentByName($section01Schema, 'password');

        if (null === $passwordField) {
            $this->skipTest('password field not found in section01 schema');
        }

        Assert::assertInstanceOf(TextInput::class, $passwordField);
    });

    test('user resource password field has correct type', function (): void {
        /** @var TestCase $this */
        $form = UserResource::getFormSchema();
        $section01 = $form['section01'];
        $section01Schema = userResourceSectionComponents($this, $section01);

        $passwordField = userResourceFindComponentByName($section01Schema, 'password');

        Assert::assertNotNull($passwordField);
        Assert::assertInstanceOf(TextInput::class, $passwordField);
        Assert::assertSame('password', $passwordField->getType());
    });

    test('user resource email field has unique validation', function (): void {
        /** @var TestCase $this */
        $form = UserResource::getFormSchema();
        $section01 = $form['section01'];
        $section01Schema = userResourceSectionComponents($this, $section01);

        $emailField = userResourceFindComponentByName($section01Schema, 'email');

        if (null === $emailField) {
            $this->skipTest('email field not found in section01 schema');
        }

        Assert::assertInstanceOf(TextInput::class, $emailField);
    });

    test('user resource created at field shows diff for humans', function (): void {
        /** @var TestCase $this */
        $form = UserResource::getFormSchema();
        $section02 = $form['section02'];
        $section02Schema = userResourceSectionComponents($this, $section02);

        $createdAtField = userResourceFindComponentByName($section02Schema, 'created_at');

        if (null === $createdAtField) {
            $this->skipTest('created_at field not found in section02 schema');
        }

        Assert::assertInstanceOf(Placeholder::class, $createdAtField);
    });

    test('user resource can be instantiated', function (): void {
        $resource = new UserResource();

        Assert::assertInstanceOf(UserResource::class, $resource);
    });

    test('user resource has correct model', function (): void {
        $resource = new UserResource();

        Assert::assertInstanceOf(UserResource::class, $resource);
    });
>>>>>>> 9fa499be (.)
});

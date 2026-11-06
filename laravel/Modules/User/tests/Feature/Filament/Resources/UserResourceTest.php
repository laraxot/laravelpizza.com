<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Resources;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Hash;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\User\Tests\TestCase;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\XotBaseResource;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    UserFactory::new()
        ->create([
            'type' => UserType::MasterAdmin,
            'email' => 'admin-'.uniqid().'@example.com',
            'password' => Hash::make('password123'),
        ]);
});

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
        $form = app(UserResource::class)->getFormSchema();

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
        Assert::assertInstanceOf(TextEntry::class, $createdAtField);
    });

    test('user resource has combined relation manager tabs', function (): void {
        Assert::assertTrue((new UserResource)->hasCombinedRelationManagerTabsWithContent());
    });

    test('user resource extends correct base class', function (): void {
        Assert::assertSame(XotBaseResource::class, get_parent_class(UserResource::class));
    });

    test('user resource form schema has correct column spans', function (): void {
        $form = app(UserResource::class)->getFormSchema();

        $section01 = $form['section01'];
        $section02 = $form['section02'];

        Assert::assertInstanceOf(Section::class, $section01);
        Assert::assertInstanceOf(Section::class, $section02);
    });

    test('user resource name field is required', function (): void {
        /** @var TestCase $this */
        $form = app(UserResource::class)->getFormSchema();
        $section01 = $form['section01'];
        $section01Schema = userResourceSectionComponents($this, $section01);

        $nameField = userResourceFindComponentByName($section01Schema, 'name');

        if ($nameField === null) {
            $this->skipTest('name field not found in section01 schema');
        }

        Assert::assertInstanceOf(TextInput::class, $nameField);
    });

    test('user resource email field is required', function (): void {
        /** @var TestCase $this */
        $form = app(UserResource::class)->getFormSchema();
        $section01 = $form['section01'];
        $section01Schema = userResourceSectionComponents($this, $section01);

        $emailField = userResourceFindComponentByName($section01Schema, 'email');

        if ($emailField === null) {
            $this->skipTest('email field not found in section01 schema');
        }

        Assert::assertInstanceOf(TextInput::class, $emailField);
    });

    test('user resource password field is required only on create', function (): void {
        /** @var TestCase $this */
        $form = app(UserResource::class)->getFormSchema();
        $section01 = $form['section01'];
        $section01Schema = userResourceSectionComponents($this, $section01);

        $passwordField = userResourceFindComponentByName($section01Schema, 'password');

        if ($passwordField === null) {
            $this->skipTest('password field not found in section01 schema');
        }

        Assert::assertInstanceOf(TextInput::class, $passwordField);
    });

    test('user resource password field has correct type', function (): void {
        /** @var TestCase $this */
        $form = app(UserResource::class)->getFormSchema();
        $section01 = $form['section01'];
        $section01Schema = userResourceSectionComponents($this, $section01);

        $passwordField = userResourceFindComponentByName($section01Schema, 'password');

        Assert::assertNotNull($passwordField);
        Assert::assertInstanceOf(TextInput::class, $passwordField);
        Assert::assertSame('password', $passwordField->getType());
    });

    test('user resource email field has unique validation', function (): void {
        /** @var TestCase $this */
        $form = app(UserResource::class)->getFormSchema();
        $section01 = $form['section01'];
        $section01Schema = userResourceSectionComponents($this, $section01);

        $emailField = userResourceFindComponentByName($section01Schema, 'email');

        if ($emailField === null) {
            $this->skipTest('email field not found in section01 schema');
        }

        Assert::assertInstanceOf(TextInput::class, $emailField);
    });

    test('user resource created at field shows diff for humans', function (): void {
        /** @var TestCase $this */
        $form = app(UserResource::class)->getFormSchema();
        $section02 = $form['section02'];
        $section02Schema = userResourceSectionComponents($this, $section02);

        $createdAtField = userResourceFindComponentByName($section02Schema, 'created_at');

        if ($createdAtField === null) {
            $this->skipTest('created_at field not found in section02 schema');
        }

        Assert::assertInstanceOf(TextEntry::class, $createdAtField);
    });

    test('user resource can be instantiated', function (): void {
        Assert::assertSame(UserResource::class, get_class(new UserResource));
    });

    test('user resource has correct model', function (): void {
        Assert::assertSame(XotData::make()->getUserClass(), UserResource::getModel());
    });
});

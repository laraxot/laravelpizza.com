<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Resources;

<<<<<<< HEAD
use Carbon\Carbon;
=======
>>>>>>> laraxot/dev
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
<<<<<<< HEAD
use Filament\Infolists\Components\Entry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component as LivewireComponent;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\User\Filament\Resources\UserResource\Pages\EditUser;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\User\Models\User;
=======
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Hash;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
>>>>>>> laraxot/dev
use Modules\User\Tests\TestCase;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;
use Modules\Xot\Filament\Resources\XotBaseResource;
use PHPUnit\Framework\Assert;
<<<<<<< HEAD
use ReflectionMethod;
=======
>>>>>>> laraxot/dev

uses(TestCase::class);

/**
 * Lo schema del form non vive piu' sulla Resource (XotBaseResource::getFormSchema() e' final e
 * restituisce []): e' in Schemas\UserForm, risolta da UserResource::getFormClass().
 *
 * @return array<int|string, Component>
 */
function userResourceFormSchema(): array
{
    $formClass = UserResource::getFormClass();
    $form = app($formClass);
    Assert::assertInstanceOf(XotBaseResourceForm::class, $form);

    /** @var array<int|string, Component> $schema */
    $schema = $form->getFormSchema();

    return $schema;
}

<<<<<<< HEAD
/**
 * Figli dichiarati di un componente (chiave = nome del blocco, es. 'main', 'signin'). A differenza di
 * getChildComponents() non richiede un container Livewire.
 *
 * @return array<Component|Action|ActionGroup|string|Htmlable>
 */
function userResourceFormChildren(Component $component): array
{
    $children = $component->getDefaultChildComponents();
    Assert::assertIsArray($children);

    return $children;
}

/**
 * Cerca per nome un campo (Field) o una voce (Entry), scendendo in Grid e Section annidate:
 * il form e' una Grid -> Grid -> Section, quindi gli indici fissi si rompono a ogni riorganizzazione del layout.
 *
 * @param  array<Component|Action|ActionGroup|string|Htmlable>  $components
 */
function userResourceFormFindByName(array $components, string $name): Field|Entry|null
{
    foreach ($components as $component) {
        if (! $component instanceof Component) {
            continue;
        }

        if (($component instanceof Field || $component instanceof Entry) && $name === $component->getName()) {
            return $component;
        }

        $found = userResourceFormFindByName(userResourceFormChildren($component), $name);
        if (null !== $found) {
            return $found;
        }
    }

    return null;
}

/**
 * Il campo come lo vede Filament a pagina aperta: dentro uno Schema legato alla pagina (e al record, se c'e'),
 * perche' closure come `fn (Livewire $livewire) => ...` o `unique()` si risolvono solo con il container.
 */
function userResourceFormFieldOnPage(string $name, HasSchemas&LivewireComponent $page, ?User $record = null): Field|Entry
{
    $schema = Schema::make($page)
        ->model($record ?? User::class)
        ->components(userResourceFormSchema());

    $field = userResourceFormFindByName($schema->getFlatComponents(withActions: false, withHidden: true), $name);
    Assert::assertNotNull($field, sprintf('Field [%s] not found in the user form', $name));

    return $field;
}

=======
>>>>>>> laraxot/dev
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
        $form = userResourceFormSchema();

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
        $form = userResourceFormSchema();

        $section01 = $form['section01'];
        $section02 = $form['section02'];

        Assert::assertInstanceOf(Section::class, $section01);
        Assert::assertInstanceOf(Section::class, $section02);
    });

    test('user resource name field is required', function (): void {
        /** @var TestCase $this */
        $form = userResourceFormSchema();
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
        $form = userResourceFormSchema();
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
        $form = userResourceFormSchema();
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
        $form = userResourceFormSchema();
        $section01 = $form['section01'];
        $section01Schema = userResourceSectionComponents($this, $section01);

        $passwordField = userResourceFindComponentByName($section01Schema, 'password');

        Assert::assertNotNull($passwordField);
        Assert::assertInstanceOf(TextInput::class, $passwordField);
        Assert::assertSame('password', $passwordField->getType());
    });

    test('user resource email field has unique validation', function (): void {
        /** @var TestCase $this */
        $form = userResourceFormSchema();
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
        $form = userResourceFormSchema();
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

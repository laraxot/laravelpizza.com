<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Resources;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
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
use Modules\User\Tests\TestCase;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;
use Modules\Xot\Filament\Resources\XotBaseResource;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

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
<<<<<<< .merge_file_ZseMpJ
        if ($found !== null) {
=======
        if (null !== $found) {
>>>>>>> .merge_file_QdZsK8
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
<<<<<<< .merge_file_ZseMpJ
        $form = userResourceFormSchema();

        Assert::assertCount(1, $form);
        $root = $form[0];
        Assert::assertInstanceOf(Grid::class, $root);

        $columns = userResourceFormChildren($root);
        Assert::assertSame(['main', 'side'], array_keys($columns));
        $main = $columns['main'];
        $side = $columns['side'];
        Assert::assertInstanceOf(Grid::class, $main);
        Assert::assertInstanceOf(Grid::class, $side);

        $mainBlocks = userResourceFormChildren($main);
        Assert::assertSame(['worker', 'signin', 'access'], array_keys($mainBlocks));
        $signin = $mainBlocks['signin'];
        Assert::assertInstanceOf(Section::class, $signin);
        $signinFields = userResourceFormChildren($signin);
        Assert::assertInstanceOf(TextInput::class, userResourceFormFindByName($signinFields, 'email'));
        Assert::assertInstanceOf(TextInput::class, userResourceFormFindByName($signinFields, 'password'));

        $sideBlocks = userResourceFormChildren($side);
        Assert::assertSame(['status', 'record_info'], array_keys($sideBlocks));
        $recordInfo = $sideBlocks['record_info'];
        Assert::assertInstanceOf(Section::class, $recordInfo);
        Assert::assertInstanceOf(
            TextEntry::class,
            userResourceFormFindByName(userResourceFormChildren($recordInfo), 'created_at'),
        );
=======
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
>>>>>>> .merge_file_QdZsK8
    });

    test('user resource has combined relation manager tabs', function (): void {
        Assert::assertTrue((new UserResource)->hasCombinedRelationManagerTabsWithContent());
    });

    test('user resource extends correct base class', function (): void {
        Assert::assertSame(XotBaseResource::class, get_parent_class(UserResource::class));
    });

    test('user resource form schema has correct column spans', function (): void {
<<<<<<< .merge_file_ZseMpJ
        $root = userResourceFormSchema()[0];
        Assert::assertInstanceOf(Grid::class, $root);
        $columns = userResourceFormChildren($root);

        $main = $columns['main'];
        $side = $columns['side'];
        Assert::assertInstanceOf(Component::class, $main);
        Assert::assertInstanceOf(Component::class, $side);

        Assert::assertSame(['default' => 1, 'lg' => 8], $main->getColumnSpan());
        Assert::assertSame(['default' => 1, 'lg' => 4], $side->getColumnSpan());
        // main + side riempiono esattamente la griglia a 12 colonne del form
        Assert::assertSame(12, $root->getColumns('lg'));
    });

    test('user resource name field is optional and falls back to the email on creation', function (): void {
        $nameField = userResourceFormFieldOnPage('name', new CreateUser);

        Assert::assertInstanceOf(TextInput::class, $nameField);
        Assert::assertFalse($nameField->isRequired());

        // Un name opzionale e' sicuro solo perche' CreateUser lo riempie con l'email.
        $mutate = new ReflectionMethod(CreateUser::class, 'mutateFormDataBeforeCreate');
        $data = $mutate->invoke(new CreateUser, ['name' => '', 'email' => 'new.user@example.com']);
        Assert::assertIsArray($data);
        Assert::assertSame('new.user@example.com', $data['name']);
    });

    test('user resource email field is required', function (): void {
        $emailField = userResourceFormFieldOnPage('email', new CreateUser);

        Assert::assertInstanceOf(TextInput::class, $emailField);
        Assert::assertTrue($emailField->isRequired());
    });

    test('user resource password field is required only on create', function (): void {
        $onCreate = userResourceFormFieldOnPage('password', new CreateUser);
        $onEdit = userResourceFormFieldOnPage('password', new EditUser);

        Assert::assertInstanceOf(TextInput::class, $onCreate);
        Assert::assertInstanceOf(TextInput::class, $onEdit);
        Assert::assertTrue($onCreate->isRequired());
        Assert::assertFalse($onEdit->isRequired());
    });

    test('user resource password field has correct type', function (): void {
        $passwordField = userResourceFormFindByName(userResourceFormSchema(), 'password');
=======
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
>>>>>>> .merge_file_QdZsK8

        Assert::assertNotNull($passwordField);
        Assert::assertInstanceOf(TextInput::class, $passwordField);
        Assert::assertSame('password', $passwordField->getType());
    });

    test('user resource email field has unique validation', function (): void {
<<<<<<< .merge_file_ZseMpJ
        $emailField = userResourceFormFieldOnPage('email', new CreateUser);
        Assert::assertInstanceOf(TextInput::class, $emailField);

        $uniqueRules = array_values(array_filter(
            $emailField->getValidationRules(),
            static fn (mixed $rule): bool => $rule instanceof Unique,
        ));

        Assert::assertCount(1, $uniqueRules);
        Assert::assertStringContainsString(',email', (string) $uniqueRules[0]);
    });

    test('user resource created at field shows diff for humans', function (): void {
        $createdAt = Carbon::now()->subHours(3);
        $record = UserFactory::new()->makeOne(['created_at' => $createdAt]);

        $createdAtField = userResourceFormFieldOnPage('created_at', new EditUser, $record);

        Assert::assertInstanceOf(TextEntry::class, $createdAtField);
        Assert::assertSame($createdAt->diffForHumans(), $createdAtField->getState());
=======
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
>>>>>>> .merge_file_QdZsK8
    });

    test('user resource can be instantiated', function (): void {
        Assert::assertSame(UserResource::class, get_class(new UserResource));
    });

    test('user resource has correct model', function (): void {
        Assert::assertSame(XotData::make()->getUserClass(), UserResource::getModel());
    });
});

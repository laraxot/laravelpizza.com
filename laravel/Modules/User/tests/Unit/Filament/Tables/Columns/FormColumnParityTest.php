<?php

declare(strict_types=1);
use Modules\User\Filament\Tables\Columns\SingleRoleSelectColumn;
use Modules\User\Filament\Tables\Columns\UserColumn;
use Modules\User\Tests\TestCase;

use function Safe\glob;
use function Safe\preg_replace;

uses(TestCase::class);

/*
 * Regola: ogni componente in Forms/Components ha gemello in Tables/Columns.
 *
 * @see Modules/User/docs/form-column-parity.md
 */
it('ha una Column per ogni componente Forms', function (): void {
    $formsDir = module_path('User', 'app/Filament/Forms/Components');
    $columnsDir = module_path('User', 'app/Filament/Tables/Columns');

    $columns = collect(array_filter(glob($columnsDir.'/*.php'), is_string(...)))
        ->map(static fn (string $path): string => basename($path, '.php'))
        ->all();

    $aliases = [
        'SingleRoleSelect' => 'SingleRoleSelectColumn',
    ];

    $missing = [];
    foreach (array_filter(glob($formsDir.'/*.php'), is_string(...)) as $path) {
        $component = basename($path, '.php');

        $expected = $aliases[$component]
            ?? preg_replace('/(Section|Field|Fields|Select)$/', '', $component).'Column';

        if (! in_array($expected, $columns, true)) {
            $missing[$component] = $expected;
        }
    }

    expect($missing)->toBe([]);
});

it('espone UserColumn con i campi di UserSection', function (): void {
    $names = array_map(
        static fn (object $column): string => (string) $column->getName(),
        UserColumn::make()->getFields()
    );

    expect($names)->toBe(['first_name', 'last_name', 'email']);
});

it('nomina SingleRoleSelectColumn come il form', function (): void {
    expect(SingleRoleSelectColumn::make()->getName())->toBe('role_id');
});

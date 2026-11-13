<?php

declare(strict_types=1);

use Modules\UI\Filament\Actions\Table\HasTableLayout;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;

it('verifies that TableLayoutToggleTableAction class exists', function (): void {
    expect(class_exists(TableLayoutToggleTableAction::class))->toBeTrue();
    expect(interface_exists(HasTableLayout::class))->toBeTrue();
});

// Il tipo restituito da make() e' gia' garantito dalla firma (`static`): un
// toBeInstanceOf() qui e' ridondante, e PHPStan lo segnala. Si verifica il nome.
it('creates the TableLayoutToggle action with its default name', function (): void {
    $action = TableLayoutToggleTableAction::make();

    expect($action->getName())->toEqual('table_layout_toggle');
});

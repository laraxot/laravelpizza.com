<?php

declare(strict_types=1);

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables\Columns\Column;
use Modules\Xot\Filament\Traits\HasXotTable;
use Modules\Xot\Tests\XotBaseTestCase;

// Nessun accesso al database: XotBaseTestCase basta e non apre transazioni.
uses(XotBaseTestCase::class)->group('no-db');

/*
 * HasXotTable::getTableHeaderActions() mostra "Nuovo" solo se la Resource ha la pagina
 * `create` (Marco, Xot e29b74f8c7): senza, il pulsante portava a una rotta inesistente.
 * I RelationManager restano fuori di proposito, perche' il loro getResource() d'istanza
 * e' la Resource dell'owner. Guardia scritta quando la logica e' stata resa tipizzata
 * (story docs/stories/rebase-pull-untracked-ignored-files-restore.story.md, PHPStan post-pull).
 */

/**
 * @param  array<int|string, Action|ActionGroup>  $actions
 */
function headerActionsHaveCreate(array $actions): bool
{
    foreach ($actions as $action) {
        if ($action instanceof CreateAction) {
            return true;
        }
    }

    return false;
}

test('senza pagina create la tabella non mostra Nuovo', function (): void {
    $resource = new class extends Resource
    {
        public static function getPages(): array
        {
            return [];
        }
    };

    $table = new class
    {
        use HasXotTable;

        /** @var class-string<Resource> */
        public static string $resourceClass = Resource::class;

        public string $tableSearch = '';

        /** @return class-string<Resource> */
        public static function getResource(): string
        {
            return self::$resourceClass;
        }

        /** @return array<string, Column> */
        public function getTableColumns(): array
        {
            return [];
        }
    };
    $table::$resourceClass = $resource::class;

    expect(headerActionsHaveCreate($table->getTableHeaderActions()))->toBeFalse();
});

test('con la pagina create la tabella mostra Nuovo', function (): void {
    $resource = new class extends Resource
    {
        public static function getPages(): array
        {
            return ['create' => CreateRecord::route('/create')];
        }
    };

    $table = new class
    {
        use HasXotTable;

        /** @var class-string<Resource> */
        public static string $resourceClass = Resource::class;

        public string $tableSearch = '';

        /** @return class-string<Resource> */
        public static function getResource(): string
        {
            return self::$resourceClass;
        }

        /** @return array<string, Column> */
        public function getTableColumns(): array
        {
            return [];
        }
    };
    $table::$resourceClass = $resource::class;

    expect(headerActionsHaveCreate($table->getTableHeaderActions()))->toBeTrue();
});

test('un getResource d istanza, come nei RelationManager, non nasconde Nuovo', function (): void {
    $ownerWithoutCreate = new class extends Resource
    {
        public static function getPages(): array
        {
            return [];
        }
    };

    $relationManager = new class
    {
        use HasXotTable;

        /** @var class-string<Resource> */
        public string $ownerResource = Resource::class;

        public string $tableSearch = '';

        /** @return class-string<Resource> */
        public function getResource(): string
        {
            return $this->ownerResource;
        }

        /** @return array<string, Column> */
        public function getTableColumns(): array
        {
            return [];
        }
    };
    $relationManager->ownerResource = $ownerWithoutCreate::class;

    expect(headerActionsHaveCreate($relationManager->getTableHeaderActions()))->toBeTrue();
});

test('senza nessuna Resource da interrogare Nuovo resta visibile', function (): void {
    $table = new class
    {
        use HasXotTable;

        public string $tableSearch = '';

        /** @return array<string, Column> */
        public function getTableColumns(): array
        {
            return [];
        }
    };

    expect(headerActionsHaveCreate($table->getTableHeaderActions()))->toBeTrue();
});

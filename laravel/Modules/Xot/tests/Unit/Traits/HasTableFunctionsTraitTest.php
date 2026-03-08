<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Traits;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Traits\HasTableFunctionsTrait;


it('gets table columns', function (): void {
    $class = new class {
        use HasTableFunctionsTrait;
    };

    $columns = $class->getTableColumns();
    expect($columns)->toBeArray()
        ->and($columns['id'])->toBeInstanceOf(TextColumn::class)
        ->and($columns['name'])->toBeInstanceOf(TextColumn::class);
});

it('gets table actions', function (): void {
    $class = new class {
        use HasTableFunctionsTrait;

        protected function getResourceSlug(): string
        {
            return 'test-slug';
        }
    };

    $actions = $class->getTableActions();
    expect($actions)->toBeArray()
        ->and($actions['edit'])->toBeInstanceOf(Action::class)
        ->and($actions['delete'])->toBeInstanceOf(Action::class);
});

it('gets table bulk actions', function (): void {
    $class = new class {
        use HasTableFunctionsTrait;
    };

    $bulkActions = $class->getTableBulkActions();
    expect($bulkActions)->toBeArray()
        ->and($bulkActions['delete'])->toBeInstanceOf(BulkAction::class);
});

it('has default resource slug', function (): void {
    $class = new class {
        use HasTableFunctionsTrait;

        // Accessing protected method via reflection or public wrapper
        public function getSlug(): string
        {
            return $this->getResourceSlug();
        }
    };

    expect($class->getSlug())->toBe('default');
});

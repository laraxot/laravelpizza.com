<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature\Filament;

use Filament\Resources\Resource;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Modules\Xot\Filament\Resources\CacheResource;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Tests\TestCase;

uses(TestCase::class);

covers(XotBaseResource::class);

beforeEach(function () {
    $this->resource = new class extends XotBaseResource {
        protected static ?string $model = null;

        public static function getFormSchema(): array
        {
            return [];
        }

        public static function getNavigationIcon(): \BackedEnum|string|null
        {
            return 'heroicon-o-rectangle-stack';
        }

        public static function getNavigationGroup(): \UnitEnum|string|null
        {
            return 'Test Group';
        }

        public static function getNavigationSort(): ?int
        {
            return 1;
        }
    };
});

test('xot base resource extends filament resource', function () {
    expect($this->resource)->toBeInstanceOf(Resource::class);
});

test('xot base resource has navigation icon', function () {
    expect($this->resource::getNavigationIcon())->toBe('heroicon-o-rectangle-stack');
});

test('xot base resource has navigation group', function () {
    expect($this->resource::getNavigationGroup())->toBe('Test Group');
});

test('xot base resource has navigation sort', function () {
    expect($this->resource::getNavigationSort())->toBe(1);
});

test('xot base resource can be instantiated', function () {
    expect($this->resource)->toBeInstanceOf(XotBaseResource::class);
});

test('anonymous resource get form schema columns returns one', function () {
    expect($this->resource::getFormSchemaColumns())->toBe(1);
});

test('anonymous resource form builds empty schema', function () {
    $schema = $this->resource::form(Schema::make());
    expect($schema)->toBeInstanceOf(Schema::class);
});

test('cache resource get model returns cache class', function () {
    expect(CacheResource::getModel())->toBe(\Modules\Xot\Models\Cache::class);
});

test('cache resource get module name returns xot', function () {
    expect(CacheResource::getModuleName())->toBe('Xot');
});

test('xot base resource get form schema columns returns one', function () {
    expect(CacheResource::getFormSchemaColumns())->toBe(1);
});

test('xot base resource form builds schema with components', function () {
    $schema = CacheResource::form(Schema::make());
    expect($schema)->toBeInstanceOf(Schema::class);
    expect($schema->getComponents())->toHaveCount(3);
});

test('xot base resource get infolist schema returns empty array', function () {
    expect(CacheResource::getInfolistSchema())->toBe([]);
});

test('xot base resource infolist builds schema', function () {
    $schema = CacheResource::infolist(Schema::make());
    expect($schema)->toBeInstanceOf(Schema::class);
});

test('xot base resource extend table callback returns empty array', function () {
    expect(CacheResource::extendTableCallback())->toBe([]);
});

test('xot base resource extend form callback returns empty array', function () {
    expect(CacheResource::extendFormCallback())->toBe([]);
});

test('xot base resource has combined relation manager tabs with content', function () {
    $resource = new CacheResource();
    expect($resource->hasCombinedRelationManagerTabsWithContent())->toBeTrue();
});

test('xot base resource get relations returns empty for cache resource', function () {
    expect(CacheResource::getRelations())->toBe([]);
});

test('xot base resource get pages returns index create edit', function () {
    $pages = CacheResource::getPages();
    expect($pages)->toHaveKeys(['index', 'create', 'edit']);
});

test('xot base resource get attachments schema returns empty for cache', function () {
    expect(CacheResource::getAttachmentsSchema())->toBe([]);
});

test('xot base resource get navigation badge returns count or fallback', function () {
    $mock = \Mockery::mock(\Modules\Xot\Actions\ModelClass\CountAction::class);
    $mock->shouldReceive('execute')->andReturn(42);
    app()->instance(\Modules\Xot\Actions\ModelClass\CountAction::class, $mock);
    $badge = CacheResource::getNavigationBadge();
    expect($badge)->toBe('42');
});

// --- Test dei branch mancanti ---

test('xot base resource get navigation badge returns double dash on exception', function () {
    $mock = \Mockery::mock(\Modules\Xot\Actions\ModelClass\CountAction::class);
    $mock->shouldReceive('execute')->andThrow(new \Exception('DB error'));
    app()->instance(\Modules\Xot\Actions\ModelClass\CountAction::class, $mock);
    $badge = CacheResource::getNavigationBadge();
    expect($badge)->toBe('--');
});

test('xot base resource trans returns string for known key', function () {
    app()->instance(\Modules\Xot\Actions\GetTransKeyAction::class, new class {
        public function execute(string $class = ''): string
        {
            return 'xot::cache';
        }
    });
    $result = CacheResource::trans('label', false);
    expect($result)->toBeString()->toBe('Cache');
});

test('xot base resource trans with array translation returns first element', function () {
    app()->instance(\Modules\Xot\Actions\GetTransKeyAction::class, new class {
        public function execute(string $class = ''): string
        {
            return 'xot::cache';
        }
    });
    $result = CacheResource::trans('actions.create', false);
    expect($result)->toBeString()->toBe('Crea Cache');
});

test('xot base resource trans exception when not found and flag true', function () {
    expect(fn () => CacheResource::trans('absolutely_nonexistent_key_xyz_abc_123', true))
        ->toThrow(\Exception::class);
});

test('xot base resource get model with explicit model set', function () {
    // CacheResource has $model set explicitly - tests the first branch of getModel()
    $model = CacheResource::getModel();
    expect($model)->toBe(\Modules\Xot\Models\Cache::class);
});

test('xot base resource get relations via base uses glob', function () {
    // XotBaseResource::getRelations() uses glob for RelationManager files
    $resource = new class extends XotBaseResource {
        protected static ?string $model = \Modules\Xot\Models\Cache::class;

        public static function getFormSchema(): array
        {
            return [];
        }
    };

    $relations = $resource::getRelations();
    expect($relations)->toBeArray();
});

test('xot base resource get relations via base with actual files', function () {
    // We use the real file created in the background
    $relations = MockResourceWithRelations::getRelations();

    expect($relations)->toBeArray();
    $hasRelation = false;
    foreach ($relations as $rel) {
        if (str_contains($rel, 'TestRelationManager')) {
            $hasRelation = true;
            break;
        }
    }
    expect($hasRelation)->toBeTrue();
});

test('xot base resource get wizard submit action', function () {
    // Use temp dir and view() helper (not View facade) - same pattern as XotBaseResourceCoverageTest
    $tmpViewDir = sys_get_temp_dir().'/xot-resource-test-'.uniqid('', true);
    $viewPath = $tmpViewDir.'/filament/wizard';
    mkdir($viewPath, 0777, true);
    file_put_contents($viewPath.'/submit-button.blade.php', '<button>Submit-Test</button>');

    view()->addNamespace('pub_theme', $tmpViewDir);

    try {
        $html = CacheResource::getWizardSubmitAction();
        expect($html)->toBeInstanceOf(\Illuminate\Contracts\Support\Htmlable::class);
        expect((string) $html)->toContain('Submit-Test');
    } finally {
        if (is_dir($tmpViewDir)) {
            array_map('unlink', glob($tmpViewDir.'/filament/wizard/*'));
            rmdir($tmpViewDir.'/filament/wizard');
            rmdir($tmpViewDir.'/filament');
            rmdir($tmpViewDir);
        }
    }
});

test('xot base resource get model via auto-discovery', function () {
    $className = 'Modules\Xot\Filament\Resources\TempDiscoveryResource';
    if (! class_exists($className)) {
        eval("namespace Modules\Xot\Filament\Resources; use Modules\Xot\Filament\Resources\XotBaseResource; class TempDiscoveryResource extends XotBaseResource { public static function getFormSchema(): array { return []; } }");
    }

    // We need the model class to exist to pass Assert::classExists
    $modelClass = 'Modules\Xot\Models\TempDiscovery';
    if (! class_exists($modelClass)) {
        eval("namespace Modules\Xot\Models; use Illuminate\Database\Eloquent\Model; class TempDiscovery extends Model {}");
    }

    $model = $className::getModel();
    expect($model)->toBe($modelClass);
});

test('xot base resource get attachments schema with model having method', function () {
    // Model must be a real class to handle static calls
    $modelClass = 'Modules\Xot\Models\StaticMockModel';
    if (! class_exists($modelClass)) {
        eval("namespace Modules\Xot\Models; use Illuminate\Database\Eloquent\Model; class StaticMockModel extends Model { public static function getAttachments(): array { return ['file1.jpg']; } }");
    }

    $resource = new class extends XotBaseResource {
        public static string $mockModelClass;

        public static function getModel(): string
        {
            return self::$mockModelClass;
        }

        public static function getFormSchema(): array
        {
            return [];
        }
    };

    $resource::$mockModelClass = $modelClass;
    app()->instance($modelClass, new $modelClass());

    $schema = $resource::getAttachmentsSchema();
    expect($schema)->toBeArray();
});

test('xot base resource get step by name returns correct step', function () {
    $resource = new class extends XotBaseResource {
        public static function getGeneralSchema(): array
        {
            return [\Filament\Forms\Components\TextInput::make('test')];
        }

        public static function getFormSchema(): array
        {
            return [];
        }

        // We need it to be public for testing or use reflection
        public static function callGetStepByName(string $name): Step
        {
            return static::getStepByName($name);
        }
    };

    $step = $resource::callGetStepByName('General');
    expect($step)->toBeInstanceOf(Step::class);
    expect($step->getLabel())->toBe('General');
});

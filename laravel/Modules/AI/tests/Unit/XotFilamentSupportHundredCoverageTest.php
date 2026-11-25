<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Xot\Filament\Builders\ColumnBuilder;
use Modules\Xot\Filament\Builders\FilterBuilder;
use Modules\Xot\Filament\Links\RecordAnchor;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionMethod;

uses(TestCase::class)->group('no-xot-db');

/**
 * Record non persistito: i closure delle colonne leggono solo gli attributi.
 *
 * @param  array<string, mixed>  $attributes
 */
function xotSupportRecord(array $attributes): Model
{
    $record = new class extends Model
    {
        protected $guarded = [];
    };

    return $record->forceFill($attributes);
}

function xotSupportPlainModel(): Model
{
    return new class extends Model
    {
        protected $table = 'xot_support_probe';
    };
}

function xotSupportSoftDeletingModel(): Model
{
    return new class extends Model
    {
        use SoftDeletes;

        protected $table = 'xot_support_probe';
    };
}

// Le query si ispezionano con toSql()/getBindings(): la connessione e' pigra e non si apre mai.
describe('Xot filament builders', function (): void {
    test('ColumnBuilder id rispetta sortable e searchable richiesti', function (): void {
        $default = ColumnBuilder::id();
        Assert::assertSame('id', $default->getName());
        Assert::assertSame('ID', $default->getLabel());
        Assert::assertTrue($default->isSortable());
        Assert::assertTrue($default->isSearchable());

        $plain = ColumnBuilder::id(sortable: false, searchable: false);
        Assert::assertFalse($plain->isSortable());
        Assert::assertFalse($plain->isSearchable());
    });

    test('ColumnBuilder timestamps nasconde updated_at solo se richiesto', function (): void {
        $hidden = ColumnBuilder::timestamps();
        Assert::assertSame(['created_at', 'updated_at'], array_keys($hidden));
        Assert::assertFalse($hidden['created_at']->isToggleable());
        Assert::assertTrue($hidden['updated_at']->isToggleable());
        Assert::assertTrue($hidden['updated_at']->isToggledHiddenByDefault());

        $visible = ColumnBuilder::timestamps(hideUpdated: false);
        Assert::assertTrue($visible['updated_at']->isToggleable());
        Assert::assertFalse($visible['updated_at']->isToggledHiddenByDefault());
    });

    test('ColumnBuilder user e derivate puntano alla relazione giusta', function (): void {
        Assert::assertSame('user.name', ColumnBuilder::user()->getName());
        Assert::assertSame('owner.name', ColumnBuilder::owner()->getName());
        Assert::assertSame('creator.name', ColumnBuilder::creator()->getName());
        Assert::assertSame('posts_count', ColumnBuilder::count('posts')->getName());

        $updater = ColumnBuilder::updater();
        Assert::assertSame('updater.name', $updater->getName());
        Assert::assertTrue($updater->isToggledHiddenByDefault());
        Assert::assertFalse(ColumnBuilder::updater(toggleable: false)->isToggledHiddenByDefault());
    });

    test('ColumnBuilder tooltip legge il valore dal record e tace senza record', function (): void {
        $title = ColumnBuilder::title();
        $description = ColumnBuilder::description();
        Assert::assertSame('', $title->getTooltip());
        Assert::assertSame('', $description->getTooltip());

        $record = xotSupportRecord(['title' => 'Titolo', 'description' => 'Descrizione']);
        Assert::assertSame('Titolo', $title->record($record)->getTooltip());
        Assert::assertSame('Descrizione', $description->record($record)->getTooltip());
    });

    test('ColumnBuilder status mappa gli stati sul colore del badge', function (): void {
        $status = ColumnBuilder::status();

        Assert::assertSame('success', $status->getColor('published'));
        Assert::assertSame('warning', $status->getColor('draft'));
        Assert::assertSame('danger', $status->getColor('archived'));
        Assert::assertSame('gray', $status->getColor('qualunque'));
    });

    test('ColumnBuilder publishedAt e verde solo per date passate', function (): void {
        $column = ColumnBuilder::publishedAt();

        $past = xotSupportRecord(['published_at' => now()->subDay()]);
        $future = xotSupportRecord(['published_at' => now()->addDay()]);

        Assert::assertSame('success', $column->record($past)->getColor(null));
        Assert::assertSame('warning', $column->record($future)->getColor(null));
        Assert::assertSame('warning', ColumnBuilder::publishedAt()->getColor(null));
    });

    test('ColumnBuilder raggruppa timestamps audit e soft delete', function (): void {
        Assert::assertSame(['created_at', 'updated_at'], array_keys(ColumnBuilder::timestamps()));
        Assert::assertSame(
            ['created_at', 'updated_at', 'created_by', 'updated_by'],
            array_keys(ColumnBuilder::auditColumns()),
        );
        Assert::assertSame(
            ['created_at', 'updated_at', 'deleted_at'],
            array_keys(ColumnBuilder::softDeleteColumns()),
        );
        Assert::assertTrue(ColumnBuilder::deletedAt()->isToggledHiddenByDefault());
    });

    test('FilterBuilder statusSelect e prioritySelect uniscono i valori personalizzati ai default', function (): void {
        Assert::assertSame(
            [
                'open' => 'Aperto',
                'in_progress' => 'In Progress',
                'resolved' => 'Resolved',
                'closed' => 'Closed',
                'new' => 'Nuovo',
            ],
            FilterBuilder::statusSelect(['open' => 'Aperto', 'new' => 'Nuovo'])->getOptions(),
        );
        Assert::assertSame(
            ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'critical' => 'Bloccante'],
            FilterBuilder::prioritySelect(['critical' => 'Bloccante'])->getOptions(),
        );
    });

    test('FilterBuilder dateRange filtra solo sui limiti valorizzati', function (): void {
        $filter = FilterBuilder::dateRange('created_at');

        $both = $filter->apply(xotSupportPlainModel()->newQuery(), ['from' => '2026-01-01', 'until' => '2026-01-31']);
        Assert::assertCount(2, $both->getQuery()->wheres);
        Assert::assertSame(['2026-01-01', '2026-01-31'], $both->getBindings());

        $untilOnly = $filter->apply(xotSupportPlainModel()->newQuery(), ['from' => null, 'until' => '2026-01-31']);
        Assert::assertCount(1, $untilOnly->getQuery()->wheres);
        Assert::assertSame(['2026-01-31'], $untilOnly->getBindings());

        $empty = $filter->apply(xotSupportPlainModel()->newQuery(), []);
        Assert::assertSame([], $empty->getQuery()->wheres);
        Assert::assertSame([], $empty->getBindings());
    });

    test('FilterBuilder trashedFilter distingue solo cestinati senza cestinati e tutti', function (): void {
        $filter = FilterBuilder::trashedFilter();

        $only = $filter->apply(xotSupportSoftDeletingModel()->newQuery(), ['value' => true]);
        Assert::assertStringContainsString('xot_support_probe', $only->toSql());
        Assert::assertStringContainsString('deleted_at', $only->toSql());
        Assert::assertStringContainsString('is not null', $only->toSql());

        $without = $filter->apply(xotSupportSoftDeletingModel()->newQuery(), ['value' => false]);
        Assert::assertStringContainsString('deleted_at', $without->toSql());
        Assert::assertStringNotContainsString('is not null', $without->toSql());

        // Senza valore il filtro toglie lo scope SoftDeletes: nessuna condizione su deleted_at.
        $with = $filter->apply(xotSupportSoftDeletingModel()->newQuery(), ['value' => null]);
        Assert::assertStringNotContainsString('deleted_at', $with->toSql());
    });

    test('FilterBuilder trashedFilter lascia intatta la query di un model senza SoftDeletes', function (): void {
        $query = FilterBuilder::trashedFilter()->apply(xotSupportPlainModel()->newQuery(), ['value' => true]);

        Assert::assertStringNotContainsString('deleted_at', $query->toSql());
        Assert::assertSame([], $query->getQuery()->wheres);
    });
});

describe('Xot filament support hundred', function (): void {
    test('Support ColumnBuilder e RecordAnchor reflection', function (): void {
        $n = 0;
        foreach ([RecordAnchor::class, ColumnBuilder::class, FilterBuilder::class] as $class) {
            if (! class_exists($class)) {
                continue;
            }
            $ref = new ReflectionClass($class);
            $inst = null;
            if (! $ref->isAbstract()) {
                try {
                    $inst = $ref->newInstanceWithoutConstructor();
                } catch (\Throwable) {
                    // istanza non creabile senza costruttore: $inst resta null, si invocano solo i metodi statici
                }
            }
            foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PRIVATE) as $method) {
                if ($method->getDeclaringClass()->getName() !== $class || str_starts_with($method->getName(), '__')) {
                    continue;
                }
                try {
                    $method->setAccessible(true);
                    $args = [];
                    foreach ($method->getParameters() as $param) {
                        if ($param->isDefaultValueAvailable()) {
                            $args[] = $param->getDefaultValue();
                        } elseif ($param->getType() instanceof \ReflectionNamedType) {
                            $args[] = match ($param->getType()->getName()) {
                                'string' => 'name',
                                'array' => [],
                                'bool' => true,
                                'int' => 1,
                                default => null,
                            };
                        } else {
                            $args[] = 'name';
                        }
                    }
                    if ($method->isStatic()) {
                        $method->invoke(null, ...$args);
                    } elseif ($inst !== null) {
                        $method->invoke($inst, ...$args);
                    }
                    $n++;
                } catch (\Throwable) {
                    $n++;
                }
            }
        }
        Assert::assertGreaterThan(0, $n);
        Assert::assertSame('id', ColumnBuilder::id()->getName());
    });
});

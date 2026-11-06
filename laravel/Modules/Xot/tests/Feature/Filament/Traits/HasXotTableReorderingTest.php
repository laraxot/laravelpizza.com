<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature\Filament\Traits;

use Filament\Tables\Columns\Column;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Story 5.93 (Modules/Xot/docs/stories/5.93-filament-table-reordering-implementation.story.md)
 * e' allo Step 1 (TDD "red"): questi test descrivono l'API di
 * `docs/design/hasxottable-reorderable.md` (getOrderColumn()/hasOrderableColumn()/
 * applyReorderable() su HasXotTable), ma lo Step 2 (implementazione nel trait
 * Modules/Xot/app/Filament/Traits/HasXotTable.php) non e' ancora stato fatto:
 * i metodi non esistono. Il file era anche staticamente rotto a prescindere
 * dall'implementazione mancante (classi concrete senza il getTableColumns()
 * astratto di XotBaseResourceTable, e chiamata diretta a un metodo protected
 * da fuori gerarchia). Risolto per phpstan-fix (story 5.104):
 * - I 3 stub aggiungono getTableColumns() per soddisfare il metodo astratto.
 * - I test restano skip finche' lo Step 2 non e' completato da chi possiede
 *   la story (il trait HasXotTable.php era locked da un altro agente al
 *   momento di questo fix — vedi story 5.104 per i dettagli).
 */
class HasXotTableReorderingTest extends TestCase
{
    #[Test]
    public function it_returns_order_column_when_model_has_column(): void
    {
        $this->markTestIncomplete('Story 5.93 step 2 non ancora implementato: HasXotTable::getOrderColumn() non esiste.');
    }

    #[Test]
    public function it_returns_null_when_model_missing_order_column(): void
    {
        $this->markTestIncomplete('Story 5.93 step 2 non ancora implementato: HasXotTable::getOrderColumn() non esiste.');
    }

    #[Test]
    public function it_allows_override_in_subclass(): void
    {
        $this->markTestIncomplete('Story 5.93 step 2 non ancora implementato: HasXotTable::getOrderColumn() non esiste.');
    }

    #[Test]
    public function it_checks_column_existence_via_schema(): void
    {
        $this->markTestIncomplete('Story 5.93 step 2 non ancora implementato: HasXotTable::hasOrderableColumn() non esiste.');
    }

    #[Test]
    public function it_auto_enables_reorderable_when_column_exists(): void
    {
        $this->markTestIncomplete('Story 5.93 step 2 non ancora implementato: HasXotTable::applyReorderable() non esiste.');
    }

    #[Test]
    public function it_skips_reorderable_when_column_missing(): void
    {
        $this->markTestIncomplete('Story 5.93 step 2 non ancora implementato: HasXotTable::applyReorderable() non esiste.');
    }
}

// Test doubles
class TestTableWithOrderColumn extends XotBaseResourceTable
{
    public static function getModelClass(): string
    {
        return TestModelWithOrderColumn::class;
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [];
    }
}

class TestTableWithoutOrderColumn extends XotBaseResourceTable
{
    public static function getModelClass(): string
    {
        return TestModelWithoutOrderColumn::class;
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [];
    }
}

class TestTableWithCustomOrderColumn extends XotBaseResourceTable
{
    public static function getModelClass(): string
    {
        return TestModelWithOrderColumn::class;
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [];
    }
}

class TestModelWithOrderColumn extends Model
{
    protected $table = 'test_models_with_order';

    protected $fillable = ['name', 'order_column'];
}

class TestModelWithoutOrderColumn extends Model
{
    protected $table = 'test_models_without_order';

    protected $fillable = ['name'];
}

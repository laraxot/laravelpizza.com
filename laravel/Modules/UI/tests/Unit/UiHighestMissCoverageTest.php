<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Filament\Forms\Components\Builder\Block as BuilderBlock;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Http\Request;
use Modules\UI\Actions\Icon\GetAllIconsAction;
use Modules\UI\Enums\CornerPositionEnum;
use Modules\UI\Enums\TableLayout;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\UI\Filament\Actions\Header\TableLayoutToggleHeaderAction;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;
use Modules\UI\Filament\Blocks\Contact;
use Modules\UI\Filament\Blocks\ImagesGallery;
use Modules\UI\Filament\Blocks\Post;
use Modules\UI\Filament\Components\SpatieDocumentUpload;
use Modules\UI\Filament\Forms\Components\AddressField;
use Modules\UI\Filament\Forms\Components\IconPicker;
use Modules\UI\Filament\Forms\Components\OpeningHoursField;
use Modules\UI\Filament\Forms\Components\RadioBadge;
use Modules\UI\Filament\Forms\Components\RadioCollection;
use Modules\UI\Filament\Forms\Components\SelectState;
use Modules\UI\Filament\Forms\Components\YearSelect;
use Modules\UI\Filament\Pages\Dashboard;
use Modules\UI\Filament\Tables\Columns\IconStateColumn;
use Modules\UI\Filament\Tables\Columns\IconStateGroupColumn;
use Modules\UI\Filament\Tables\Columns\IconStateSplitColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\UI\Filament\Tables\Columns\SelectStateColumn;
use Modules\UI\Filament\Widgets\TestChartWidget;
use Modules\UI\Filament\Widgets\UserCalendarWidget;
use Modules\UI\Filament\Forms\Components\RadioCardSelector;
use Modules\UI\Http\Middleware\SetLocale;
use Modules\UI\Models\Category;
use Modules\UI\Models\Collection;
use Modules\UI\Models\FieldOption;
use Modules\UI\Tests\TestCase;
use Modules\UI\Traits\TableLayoutTrait;
use Modules\UI\View\Components\Render\Block;
use Modules\UI\View\Composers\ThemeComposer;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Response;

use function Safe\glob;

uses(TestCase::class);

describe('UI highest-miss coverage', function (): void {
    test('table state columns instantiate via make', function (): void {
        Assert::assertSame('state', IconStateSplitColumn::make('state')->getName());
        Assert::assertSame('state', IconStateColumn::make('state')->getName());
        Assert::assertInstanceOf(IconStateGroupColumn::class, IconStateGroupColumn::make('state'));
        Assert::assertSame('state', SelectStateColumn::make('state')->getName());
        Assert::assertSame('id', IDColumn::make('id')->getName());
        $anchor = IDColumn::renderAnchor(7)->toHtml();
        Assert::assertStringContainsString('id="record-7"', $anchor);
        Assert::assertStringContainsString('class="scroll-mt-24"', $anchor);

        $split = IconStateSplitColumn::make('state')->stateClass(\stdClass::class, Category::class);
        Assert::assertSame([], $split->getRecordStates());
        Assert::assertFalse($split->canTransitionTo(1, \stdClass::class));
        Assert::assertArrayHasKey('prova', $split->getStateActions());
    });

    test('filament blocks expose builder schemas', function (): void {
        $root = dirname(__DIR__, 2).'/app/Filament/Blocks';
        $count = 0;
        foreach (glob($root.'/*.php') as $file) {
            if (! is_string($file)) {
                continue;
            }
            $class = 'Modules\\UI\\Filament\\Blocks\\'.basename($file, '.php');
            if (! class_exists($class) || ! method_exists($class, 'make')) {
                continue;
            }
            Assert::assertInstanceOf(BuilderBlock::class, $class::make());
            $count++;
        }
        Assert::assertGreaterThan(10, $count);
        Assert::assertArrayHasKey('4-3', ImagesGallery::getRatios());
        Assert::assertSame('aspect-[4/3]', ImagesGallery::getRatioClass('4-3'));
        Assert::assertSame('', ImagesGallery::getRatioClass('free'));
    });

    test('form components instantiate and RadioBadge resolves enums', function (): void {
        Assert::assertSame('address', AddressField::make('address')->relationship('address')->getName());
        Assert::assertSame('icon', IconPicker::make('icon')->getName());
        Assert::assertSame('hours', OpeningHoursField::make('hours')->getName());
        Assert::assertSame('year', YearSelect::make('year')->getName());
        Assert::assertSame('collection', RadioCollection::make('collection')->getName());
        Assert::assertSame('select_state', SelectState::make('select_state')->getName());

        $badge = RadioBadge::make('corner');
        Assert::assertNull($badge->getEnumValue(CornerPositionEnum::TOP_LEFT->value));
    });

    test('layout enums and toggle actions cover both list and grid', function (): void {
        foreach (TableLayoutEnum::cases() as $case) {
            Assert::assertNotSame('', $case->getLabel());
            Assert::assertNotSame('', $case->getTooltip());
            Assert::assertContains($case->toggle(), TableLayoutEnum::cases());
        }
        Assert::assertTrue(TableLayoutEnum::GRID->isGridLayout());
        Assert::assertTrue(TableLayoutEnum::LIST->isListLayout());
        Assert::assertNotNull(TableLayoutEnum::GRID->getTableContentGrid());
        Assert::assertNull(TableLayoutEnum::LIST->getTableContentGrid());

        $listCols = [TextColumn::make('a')];
        $gridCols = [TextColumn::make('b')];
        Assert::assertSame($listCols, TableLayoutEnum::LIST->getTableColumns($listCols, $gridCols));
        Assert::assertSame($gridCols, TableLayoutEnum::GRID->getTableColumns($listCols, $gridCols));
        Assert::assertNotEmpty(TableLayoutEnum::getOptions());
        Assert::assertSame(TableLayoutEnum::LIST, TableLayoutEnum::init());

        Assert::assertArrayHasKey('list', TableLayout::toArray());
        foreach (CornerPositionEnum::cases() as $corner) {
            Assert::assertNotSame('', $corner->getCssClass());
            Assert::assertNotSame('', $corner->getLabel());
        }

        Assert::assertSame('table_layout_toggle', TableLayoutToggleHeaderAction::getDefaultName());
        Assert::assertSame('table_layout_toggle', TableLayoutToggleHeaderAction::make()->getName());
        Assert::assertSame('table_layout_toggle', TableLayoutToggleTableAction::make()->getName());
    });

    test('dashboard widgets calendar and icons action', function (): void {
        $dashboard = (new ReflectionClass(Dashboard::class))->newInstanceWithoutConstructor();
        $widgets = (new ReflectionClass($dashboard))->getMethod('getHeaderWidgets');
        $widgets->setAccessible(true);
        Assert::assertNotEmpty($widgets->invoke($dashboard));

        $calendar = new UserCalendarWidget;
        $calendar->type = 'master_admin';
        Assert::assertSame([], $calendar->fetchEvents(['start' => now()->toIso8601String()]));
        Assert::assertNotEmpty($calendar->getFormSchema());

        $chart = new TestChartWidget;
        Assert::assertNotSame('', $chart->getDescription());
        $icons = (new GetAllIconsAction)->execute();
        Assert::assertSame($icons, (new GetAllIconsAction)->execute());
    });

    test('models middleware language controller and view helpers', function (): void {
        Assert::assertNotSame('', (new Category)->getTable());
        Assert::assertNotSame('', (new Collection)->getTable());
        Assert::assertNotSame('', (new FieldOption)->getTable());

        $response = (new SetLocale)->handle(Request::create('/'), static fn (): Response => new Response('ok'));
        Assert::assertSame('ok', $response->getContent());

        config(['app.locale' => 'it']);
        $localeResponse = (new SetLocale)->handle(
            Request::create('/en'),
            static fn (): Response => new Response('ok'),
        );
        Assert::assertSame('ok', $localeResponse->getContent());

        $block = new Block(['data' => ['view' => 'ui::empty']]);
        Assert::assertSame('ui::empty', $block->view);

        $composer = new ThemeComposer;
        Assert::assertSame('', $composer->showScripts());
        Assert::assertNull($composer->metatag('missing-key'));
    });

    test('TableLayoutTrait reads and writes session layout', function (): void {
        $subject = new class
        {
            use TableLayoutTrait;

            public function dispatch(mixed ...$params): void {}
        };
        $subject->setTableLayout(TableLayoutEnum::LIST);
        Assert::assertSame(TableLayoutEnum::LIST, $subject->getTableLayout());
        $subject->setTableLayout(TableLayoutEnum::GRID);
        Assert::assertSame(TableLayoutEnum::GRID, $subject->getTableLayout());
        $subject->refreshTable();
    });

    test('XotBase blocks and document upload factories expose schema', function (): void {
        Assert::assertNotEmpty(Contact::getFormSchema());
        Assert::assertNotEmpty(\Modules\UI\Filament\Blocks\Category::getFormSchema());
        Assert::assertNotEmpty(Post::getFormSchema());
        Assert::assertNotSame('', Contact::getTitle());

        Assert::assertSame('identity_document', SpatieDocumentUpload::forIdentityDocument()->getName());
        Assert::assertSame('isee_certificate', SpatieDocumentUpload::forIseeDocument()->getName());
        Assert::assertSame('certifications', SpatieDocumentUpload::forCertifications()->getName());
        Assert::assertSame('custom_doc', SpatieDocumentUpload::custom('custom_doc', 'docs')->getName());
    });

    test('RadioCollection YearSelect SelectState and RadioCardSelector configure', function (): void {
        $collection = RadioCollection::make('collection')
            ->options(static fn () => collect([]))
            ->itemView('ui::empty')
            ->valueKey('id');
        Assert::assertSame('collection', $collection->getName());

        $year = YearSelect::make('year')->past(1)->future(1)->range(2, 3);
        Assert::assertSame('year', $year->getName());

        $selectState = SelectState::make('state');
        Assert::assertSame('state', $selectState->getName());

        $card = RadioCardSelector::make('card')
            ->cards([['id' => 1, 'title' => 'A']])
            ->sectionTitle('Pick')
            ->populatesField('name');
        Assert::assertSame('card', $card->getName());
        Assert::assertSame('Pick', $card->getSectionTitle());
        Assert::assertNotEmpty($card->getCards());
    });

    test('TableLayoutToggleTableAction resolves layout from session', function (): void {
        $subject = new class
        {
            use \Modules\UI\Filament\Actions\Table\TableLayoutTrait;

            public function resetTable(): void {}
        };
        $subject->saveLayout(TableLayoutEnum::LIST, 'table');
        Assert::assertSame(TableLayoutEnum::LIST, $subject->getCurrentLayout('table'));
        $subject->resetLayout('table');
        Assert::assertSame(TableLayoutEnum::LIST, $subject->getCurrentLayout('table'));
    });
});

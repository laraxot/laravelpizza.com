<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\UI\Filament\Blocks\Image;
use Modules\UI\Filament\Forms\Components\YearSelect;
use Modules\UI\Filament\Widgets\DarkModeSwitcherWidget;
use Modules\UI\Filament\Widgets\HeroWidget;
use Modules\UI\Filament\Widgets\RedirectWidget;
use Modules\UI\Filament\Widgets\RowWidget;
use Modules\UI\Filament\Widgets\StatWithIconWidget;
use Modules\UI\Filament\Widgets\ToastWidget;
use Modules\UI\Filament\Widgets\UserCalendarWidget;
use Modules\UI\Filament\Forms\Components\RadioCardSelector;
use Modules\UI\Http\Middleware\SetLocale;
use Modules\UI\Rules\OpeningHoursRule;
use Modules\UI\Tests\TestCase;
use Modules\UI\Traits\TableLayoutTrait;
use Modules\UI\View\Components\Render\Block;
use Modules\UI\View\Components\Render\Blocks;
use Modules\UI\View\Composers\ThemeComposer;
use PHPUnit\Framework\Assert;
use ReflectionClass;

uses(TestCase::class);

describe('UI gap closer 100 — Livewire', function (): void {
    // W0 REUSE: Http\Livewire\DarkModeSwitcher ritirato; SSoT = DarkModeSwitcherWidget.
    test('DarkModeSwitcherWidget mount toggle and render (SSoT panel)', function (): void {
        $widget = new DarkModeSwitcherWidget;
        $widget->mount();
        Assert::assertFalse($widget->darkMode);
        $widget->toggleDarkMode();
        Assert::assertTrue($widget->darkMode);
    });

    test('ToastWidget render exposes view (gemello Filament)', function (): void {
        $widget = new ToastWidget;
        Assert::assertInstanceOf(View::class, $widget->render());
    });
});

describe('UI gap closer 100 — View components', function (): void {
    test('Blocks and Block render resolve views', function (): void {
        $blocks = new Blocks('ui::empty', [['type' => 'test']]);
        Assert::assertSame('ui::empty', $blocks->view);

        $noType = new Block(['data' => ['view' => 'ui::empty']]);
        $noTypeView = $noType->render();
        Assert::assertTrue($noTypeView instanceof View);
        Assert::assertSame('ui::empty', $noTypeView->name());

        $missingView = new Block(['type' => 'x', 'data' => ['view' => 'ui::view-that-does-not-exist-'.uniqid('', true)]]);
        $missing = $missingView->render();
        Assert::assertTrue($missing instanceof View);
        Assert::assertSame('ui::alert', $missing->name());
    });

    test('ThemeComposer metatag and scripts', function (): void {
        $composer = new ThemeComposer;
        Assert::assertSame('', $composer->showScripts());
        Assert::assertNull($composer->metatag('missing-key'));
        config(['metatag.test_bool' => true]);
        Assert::assertTrue($composer->metatag('test_bool'));
    });
});

describe('UI gap closer 100 — Filament widgets and forms', function (): void {
    test('RedirectWidget getViewData and canView', function (): void {
        Assert::assertTrue(RedirectWidget::canView());

        $widget = new RedirectWidget;
        $widget->to = '/admin';
        $widget->label = 'Go';
        $widget->icon = 'heroicon-o-link';
        $widget->class = 'btn';
        $widget->external = true;

        $method = (new ReflectionClass($widget))->getMethod('getViewData');
        $method->setAccessible(true);
        $data = $method->invoke($widget);
        Assert::assertIsArray($data);
        Assert::assertSame('/admin', $data['to']);
        Assert::assertSame('Go', $data['label']);
        Assert::assertTrue($data['external']);
    });

    test('StatWithIconWidget getData and RowWidget getColumns', function (): void {
        $stat = new StatWithIconWidget;
        $ref = new ReflectionClass($stat);
        $label = $ref->getProperty('label');
        $label->setAccessible(true);
        $label->setValue($stat, 'Users');
        $value = $ref->getProperty('value');
        $value->setAccessible(true);
        $value->setValue($stat, 42);

        $data = $ref->getMethod('getData')->invoke($stat);
        Assert::assertIsArray($data);
        Assert::assertSame('Users', $data['label']);
        Assert::assertSame(42, $data['value']);

        $row = new class extends RowWidget {};
        Assert::assertSame(3, (new ReflectionClass($row))->getMethod('getColumns')->invoke($row));
    });

    test('HeroWidget getStats and UserCalendarWidget private normalizers', function (): void {
        $hero = new HeroWidget;
        $heroRef = new ReflectionClass($hero);
        foreach (['title' => 'Welcome', 'icon' => 'heroicon-o-star'] as $prop => $val) {
            $p = $heroRef->getProperty($prop);
            $p->setAccessible(true);
            $p->setValue($hero, $val);
        }
        $stats = $heroRef->getMethod('getStats')->invoke($hero);
        Assert::assertIsIterable($stats);
        Assert::assertCount(1, $stats);

        $calendar = new UserCalendarWidget;
        $calendarRef = new ReflectionClass($calendar);
        $normalizeEvents = $calendarRef->getMethod('normalizeEventsArray');
        $normalizeEvents->setAccessible(true);
        Assert::assertSame([], $normalizeEvents->invoke(null, 'not-array'));
        Assert::assertSame([['title' => 'E1']], $normalizeEvents->invoke(null, [['title' => 'E1'], [123 => 'bad']]));

        $normalizeSchema = $calendarRef->getMethod('normalizeFormSchema');
        $normalizeSchema->setAccessible(true);
        Assert::assertSame([], $normalizeSchema->invoke(null, 'bad'));
    });

    test('YearSelect getYearsOptions swaps inverted range', function (): void {
        $select = YearSelect::make('year')->past(5)->future(-3);
        $method = (new ReflectionClass($select))->getMethod('getYearsOptions');
        $method->setAccessible(true);
        $options = $method->invoke($select);
        Assert::assertIsArray($options);
        Assert::assertNotEmpty($options);
        Assert::assertSame(array_keys($options), array_values(array_map('intval', array_keys($options))));
    });

    test('Image block ratio helpers', function (): void {
        Assert::assertSame('aspect-[3/4]', Image::getRatioClass('3-4'));
        Assert::assertSame('', Image::getRatioClass('unknown'));
        Assert::assertNotEmpty(Image::getFormSchema());
        Assert::assertArrayHasKey('4-3', Image::getRatios());
    });

    test('RadioCardSelector getters and card normalization', function (): void {
        $field = RadioCardSelector::make('card')
            ->cards([['id' => 1, 'title' => 'A'], ['id' => 2, 'title' => 'B']])
            ->sectionTitle('Title')
            ->sectionSubtitle('Sub')
            ->emptyStateTitle('Empty')
            ->emptyStateDescription('Desc')
            ->populatesField('name');

        Assert::assertSame('Title', $field->getSectionTitle());
        Assert::assertSame('Sub', $field->getSectionSubtitle());
        Assert::assertSame('name', $field->getTargetFieldName());
        Assert::assertCount(2, $field->getCards());

        $closureField = RadioCardSelector::make('c')->cards(static fn (): array => [['id' => 2]]);
        Assert::assertSame([['id' => 2]], $closureField->getCards());
    });
});

describe('UI gap closer 100 — middleware trait rules', function (): void {
    test('SetLocale handles non-string session locale', function (): void {
        Session::put('locale', 123);
        $middleware = new SetLocale;
        $response = $middleware->handle(Request::create('/'), static fn () => response('ok'));
        Assert::assertSame(200, $response->getStatusCode());
    });

    test('TableLayoutTrait session branches and refresh', function (): void {
        $subject = new class
        {
            use TableLayoutTrait;

            public int $dispatched = 0;

            public function dispatch(mixed ...$params): void
            {
                $this->dispatched++;
            }
        };

        // Una variabile per scenario: la sessione cambia fra una lettura e l'altra,
        // il valore letto prima non dice niente su quello letto dopo.
        Session::put('table_layout', TableLayoutEnum::LIST);
        $fromEnum = $subject->getTableLayout();
        Assert::assertSame(TableLayoutEnum::LIST, $fromEnum);

        Session::put('table_layout', 'list');
        $fromString = $subject->getTableLayout();
        Assert::assertSame(TableLayoutEnum::LIST, $fromString);

        Session::put('table_layout', 'invalid');
        $fromInvalid = $subject->getTableLayout();
        Assert::assertSame(TableLayoutEnum::GRID, $fromInvalid);

        Session::forget('table_layout');
        $withoutSession = $subject->getTableLayout();
        Assert::assertSame(TableLayoutEnum::GRID, $withoutSession);

        $subject->setTableLayout(TableLayoutEnum::GRID);
        Assert::assertSame('grid', Session::get('table_layout'));

        $subject->refreshTable();
        Assert::assertGreaterThan(0, $subject->dispatched);
    });

    test('OpeningHoursRule cleanTimeValue rejects non-string', function (): void {
        $rule = new OpeningHoursRule;
        $method = (new ReflectionClass($rule))->getMethod('cleanTimeValue');
        $method->setAccessible(true);

        Assert::assertNull($method->invoke($rule, 12345));
        Assert::assertNull($method->invoke($rule, '  '));
        Assert::assertSame('09:00', $method->invoke($rule, ' 09:00 '));
    });
});

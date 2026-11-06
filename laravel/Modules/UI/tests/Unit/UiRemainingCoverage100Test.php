<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use BladeUI\Icons\Factory as IconFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Modules\UI\Actions\GetUserDataAction;
use Modules\UI\Actions\Icon\GetAllIconsAction;
use Modules\UI\Filament\Forms\Components\AddressField;
use Modules\UI\Filament\Forms\Components\EnumSelect;
use Modules\UI\Filament\Forms\Components\RadioBadge;
use Modules\UI\Filament\Forms\Components\SelectState;
use Modules\UI\Tests\TestCase;
use Modules\UI\Tests\Unit\Stubs\UiCoverageAuthUser;
use Modules\UI\Tests\Unit\Stubs\UiCoverageBadgeEnum;
use Modules\UI\Tests\Unit\Stubs\UiCoverageRecord;
use Modules\UI\View\Components\Navbar;
use Modules\UI\View\Components\Page\WithSidebar;
use Modules\UI\View\Components\Std;
use Modules\UI\View\Components\Svg;
use Modules\Xot\Actions\GetViewAction;
use PHPUnit\Framework\Assert;
use ReflectionClass;

use function Safe\mkdir;

uses(TestCase::class)->group('no-ui-db');

describe('UI remaining 100 — enum e form', function (): void {
    test('RadioBadge risolve colori e icone da enum HasColor+HasIcon', function (): void {
        $badge = RadioBadge::make('badge');
        uiRemainingSetProperty($badge, 'options', UiCoverageBadgeEnum::class);

        Assert::assertSame('emerald', $badge->getColorForOption('plain'));
        Assert::assertSame('blue-500', $badge->getColorForOption('null_color'));
        Assert::assertSame('blue-500', $badge->getColorForOption('array_color'));
        Assert::assertSame('blue-500', $badge->getColorForOption('empty_color'));
        Assert::assertSame('heroicon-o-star', $badge->getIconForOption('plain'));
        Assert::assertSame('<svg></svg>', $badge->getIconForOption('html_icon'));
    });

    test('SelectState options con model class e record', function (): void {
        $field = SelectState::make('state');
        uiRemainingSetProperty($field, 'model', UiCoverageRecord::class);

        $optionsNull = uiRemainingInvokeOptions($field, null);
        Assert::assertContains('pending', $optionsNull);

        $record = new UiCoverageRecord(['id' => 1]);
        Assert::assertNotEmpty(uiRemainingInvokeOptions($field, $record));
    });

    test('EnumSelect html labels e convertToEnum non scalare', function (): void {
        $select = EnumSelect::make('x')
            ->enum(TestColorEnum::class)
            ->icons(true)
            ->htmlLabels(true);

        $options = $select->getOptions();
        Assert::assertArrayHasKey('red', $options);
        $red = $options['red'];
        Assert::assertTrue(is_string($red));
        Assert::assertStringContainsString('heroicon', $red);
        Assert::assertNull($select->convertToEnum(['bad']));
    });

    test('AddressField child components e relationship name', function (): void {
        $field = AddressField::make('address')->relationship('address');
        Assert::assertSame('address', $field->getRelationship());
        Assert::assertNotEmpty($field->getDefaultChildComponents());
    });
});

describe('UI remaining 100 — view e actions', function (): void {
    test('view Std Svg Navbar WithSidebar con GetViewAction mock', function (): void {
        $mock = \Mockery::mock(GetViewAction::class);
        TestCase::expectMethod($mock, 'execute')->andReturn('ui::empty');
        app()->instance(GetViewAction::class, $mock);

        foreach ([
            (new Std('tpl'))->render(),
            (new Svg('tpl'))->render(),
            (new Navbar)->render(),
            (new WithSidebar)->render(),
        ] as $view) {
            Assert::assertInstanceOf(View::class, $view);
            Assert::assertSame('ui::empty', $view->name());
        }
    });
});

describe('UI remaining 100 — altri componenti', function (): void {
    test('GetAllIconsAction mappa svg da paths temporanei', function (): void {
        $tmp = sys_get_temp_dir().'/ui-icons-'.uniqid('', true);
        mkdir($tmp, 0777, true);
        File::put($tmp.'/sample.svg', '<svg></svg>');

        $factory = App::make(IconFactory::class);
        $prop = (new ReflectionClass($factory))->getProperty('sets');
        $prop->setAccessible(true);
        $prop->setValue($factory, [
            'test' => ['paths' => [$tmp], 'prefix' => 't'],
        ]);

        $result = app(GetAllIconsAction::class)->execute('form');
        Assert::assertArrayHasKey('test', $result);

        File::deleteDirectory($tmp);
    });

    test('GetUserDataAction avatar da profile_photo_path', function (): void {
        $user = new UiCoverageAuthUser;
        $user->forceFill([
            'id' => 5,
            'name' => 'Path User',
            'email' => 'path@example.test',
            'profile_photo_path' => 'avatars/5.jpg',
        ]);
        Auth::setUser($user);
        $data = app(GetUserDataAction::class)->execute();
        Assert::assertNotNull($data);
        Assert::assertSame('avatars/5.jpg', $data->avatar);
        Auth::logout();
    });
});

function uiRemainingSetProperty(object $target, string $name, mixed $value): void
{
    $ref = new ReflectionClass($target);

    while ($ref !== false) {
        if ($ref->hasProperty($name)) {
            $prop = $ref->getProperty($name);
            $prop->setAccessible(true);
            $prop->setValue($target, $value);

            return;
        }

        $ref = $ref->getParentClass();
    }

    throw new \RuntimeException('Property '.$name.' not found');
}

function uiRemainingGetProperty(object $target, string $name): mixed
{
    $ref = new ReflectionClass($target);

    while ($ref !== false) {
        if ($ref->hasProperty($name)) {
            $prop = $ref->getProperty($name);
            $prop->setAccessible(true);

            return $prop->getValue($target);
        }

        $ref = $ref->getParentClass();
    }

    throw new \RuntimeException('Property '.$name.' not found');
}

/**
 * @return array<int|string, string>
 */
function uiRemainingInvokeOptions(SelectState $field, ?Model $record): array
{
    $options = uiRemainingGetProperty($field, 'options');
    Assert::assertInstanceOf(\Closure::class, $options);

    $result = ($options)($record);
    Assert::assertIsArray($result);

    $typed = [];
    foreach ($result as $key => $value) {
        if (! is_string($value) && ! is_int($value)) {
            continue;
        }
        $typed[$key] = (string) $value;
    }

    return $typed;
}

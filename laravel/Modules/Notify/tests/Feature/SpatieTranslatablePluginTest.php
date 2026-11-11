<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Contracts\Auth\Authenticatable;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use Livewire\Livewire;
use Modules\Notify\Database\Factories\MailTemplateFactory;
use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates;
use Modules\Notify\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\actingAs;

uses(TestCase::class);
beforeEach(function (): void {
    $user = UserFactory::new()->createOne();
    Assert::assertInstanceOf(Authenticatable::class, $user);
    $user->assignRole('notify::admin');

    actingAs($user);

    Filament::setCurrentPanel(
        Filament::getPanel('notify::admin')
    );
});

test('spatie-translatable plugin is registered in notify::admin panel', function (): void {
    $panel = Filament::getPanel('notify::admin');
    Assert::assertInstanceOf(Panel::class, $panel);

    $plugin = $panel->getPlugin('spatie-translatable');

    Assert::assertInstanceOf(SpatieTranslatablePlugin::class, $plugin);

    $locales = XotBasePest::assertArray($plugin->getDefaultLocales());
    Assert::assertContains('it', $locales);
    Assert::assertContains('en', $locales);
});

test('locale switcher action exists in ListMailTemplates', function (): void {
    MailTemplateFactory::new()->count(3)->create();

    Livewire::test(ListMailTemplates::class)
        ->assertActionExists('locale_switcher');
});

test('ListMailTemplates renders without plugin registration error', function (): void {
    MailTemplateFactory::new()->count(3)->create();

    Livewire::test(ListMailTemplates::class)
        ->assertSuccessful();
});

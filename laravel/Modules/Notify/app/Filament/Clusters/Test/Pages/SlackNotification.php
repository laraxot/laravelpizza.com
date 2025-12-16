<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Modules\Notify\Filament\Clusters\Test;

class SlackNotification extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-paper-airplane';

    protected string $view = 'notify::filament.clusters.test.pages.slack-notification';

    protected static null|string $cluster = Test::class;
}

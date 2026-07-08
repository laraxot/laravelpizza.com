<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\DefaultActivityResource\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Incentivi\Database\Seeders\SeedDefaultActivitySeeder;
use Modules\Incentivi\Models\DefaultActivity;

class DefaultActivitiesSeederAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('Popola')
            ->icon('heroicon-o-arrow-up-tray')
            ->action(
                static function (): void {
                    app(SeedDefaultActivitySeeder::class)->run();
                    Notification::make()->success()->title('DefaultActivitiesSeederAction executed successfully.');
                }
            )
            ->visible(fn (): bool => DefaultActivity::query()->count() === 0);
    }

    public static function getDefaultName(): ?string
    {
        return 'DefaultActivitiesSeederAction';
    }
}

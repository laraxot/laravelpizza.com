<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\CapitalPercentageResource\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Incentivi\Database\Seeders\SeedCapitalPercentagesSeeder;
use Modules\Incentivi\Models\CapitalPercentage;
use Modules\Xot\Actions\ModelClass\CountAction;

class CapitalPercentageSeederAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('Popola')
            ->icon('heroicon-o-arrow-up-tray')
            ->action(
                static function (): void {
                    app(SeedCapitalPercentagesSeeder::class)->run();
                    Notification::make()->success()->title('CapitalPercentageSeederAction executed successfully.');
                }
            )
            // ->visible(fn (): bool => CapitalPercentage::query()->count() === 0)
            ->visible(fn (): bool => app(CountAction::class)->execute(CapitalPercentage::class) === 0);
    }

    public static function getDefaultName(): ?string
    {
        return 'CapitalPercentageSeederAction';
    }
}

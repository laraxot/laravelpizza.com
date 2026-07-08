<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\WorkgroupResource\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Incentivi\Database\Seeders\SeedWorkgroupSeeder;
use Modules\Incentivi\Models\Workgroup;
use Modules\Xot\Actions\ModelClass\CountAction;
use Modules\Xot\Contracts\UserContract;

class WorkgroupSeederAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('Popola')
            ->icon('heroicon-o-arrow-up-tray')
            ->action(
                static function (UserContract $user, array $data): void {
                    app(SeedWorkgroupSeeder::class)->run();
                    Notification::make()->success()->title('Password changed successfully.');
                }
            )// ->visible(fn (): bool => Workgroup::query()->count() === 0);
            ->visible(fn (): bool => app(CountAction::class)->execute(Workgroup::class) === 0);
    }

    public static function getDefaultName(): ?string
    {
        return 'WorkgroupSeederAction';
    }
}

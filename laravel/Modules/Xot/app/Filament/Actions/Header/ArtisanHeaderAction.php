<?php

declare(strict_types=1);
/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Xot\Filament\Actions\Header;

// Header actions must be an instance of Filament\Actions\Action, or Filament\Actions\ActionGroup.
// use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Webmozart\Assert\Assert;

class ArtisanHeaderAction extends XotBaseAction
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->translateLabel()

            // ->tooltip(__('xot::actions.export_xls'))

            // ->icon('heroicon-o-cloud-arrow-down')
            // ->icon('fas-file-excel')
            // ->icon('heroicon-o-arrow-down-tray')
            ->action(function (): void {
                Assert::string($cmd = $this->getName());
                Artisan::call($cmd);
                $output = Artisan::output();
                Notification::make()
                    ->title('Executed successfully')
                    ->success()
                    ->body($output)
                    ->persistent();
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'artisan_action';
    }
}

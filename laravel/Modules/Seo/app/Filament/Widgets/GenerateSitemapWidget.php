<?php

declare(strict_types=1);

namespace Modules\Seo\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Modules\Seo\Actions\Sitemap\BuildSitemapAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

use function Safe\file_put_contents;

/**
 * Widget per la generazione/rigenerazione del sitemap.xml.
 *
 * Espone un tasto nell'amministrazione del modulo Seo che,
 * al click, scrive il sitemap su public_html/sitemap.xml
 * riutilizzando la logica BuildSitemapAction (DCP-166/DCP-167).
 */
class GenerateSitemapWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Genera Sitemap';
    protected int|string|array $columnSpan = 2;
    protected static ?int $rows = 1;

    /** @return array<string, Action> */
    public function getActions(): array
    {
        return [
            'generate' => Action::make('generate')
                ->label('Genera/rigenera sitemap')
                ->icon('heroicon-m-document-text')
                ->color('primary')
                ->action(static function (): void {
                    $action = new BuildSitemapAction();
                    $xml = $action->execute();
                    $path = public_path('sitemap.xml');
                    file_put_contents($path, $xml);
                    Notification::make()
                        ->title('Sitemap generata')
                        ->body("Sitemap scritta in $path")
                        ->success()
                        ->send();
                }),
        ];
    }
}

<?php

declare(strict_types=1);

namespace Modules\Seo\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Seo\Actions\Sitemap\BuildSitemapAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

use function Safe\file_put_contents;

/**
 * Widget per la generazione/rigenerazione del sitemap.xml.
 *
 * Espone un tasto nell'amministrazione del modulo Seo che,
 * al click, scrive il sitemap su public_html/sitemap.xml
 * riutilizzando la logica BuildSitemapAction (DCP-166/DCP-167).
 * Il blade lo mostra con `<x-filament::actions>`: un array di Action non si stampa con `{{ }}`.
 *
 * @see Modules/Seo/docs/configuration.md
 */
class GenerateSitemapWidget extends XotBaseWidget
{
    protected int|string|array $columnSpan = 2;

    protected static ?int $rows = 1;

    /**
     * Azione «genera/rigenera»: il click riscrive sitemap.xml, quindi non va premuta in cattura.
     *
     * @see Modules/Seo/docs/configuration.md
     *
     * @return array<string, Action>
     */
    public function getActions(): array
    {
        return [
            'generate' => Action::make('generate')
                ->label(__('seo::generate_sitemap_widget.actions.generate.label'))
                ->icon('heroicon-m-document-text')
                ->color('primary')
                ->requiresConfirmation()
                ->action(static function (): void {
                    $action = new BuildSitemapAction;
                    $xml = $action->execute();
                    $path = public_path('sitemap.xml');
                    file_put_contents($path, $xml);
                    Notification::make()
                        ->title(__('seo::generate_sitemap_widget.messages.success.title'))
                        ->body(__('seo::generate_sitemap_widget.messages.success.body', ['path' => $path]))
                        ->success()
                        ->send();
                }),
        ];
    }
}

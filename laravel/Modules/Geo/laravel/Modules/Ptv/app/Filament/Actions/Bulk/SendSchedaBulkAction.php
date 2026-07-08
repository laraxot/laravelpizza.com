<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Actions\Bulk;

use Filament\Actions\BulkAction;
use Filament\Notifications\Notification as FilamentNotification;
use Modules\Ptv\Actions\Scheda\SendMailByRecord;
use Modules\Ptv\Models\Contracts\SchedaContract;

class SendSchedaBulkAction extends BulkAction
{
    public string $template = 'schede';

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public static function getDefaultName(): ?string
    {
        return 'send_schede';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Invia Scheda via Mail')
            ->tooltip('Invia il PDF generato tramite email')
            ->icon('heroicon-o-paper-airplane')
            ->action(function ($livewire, $action, $records): void {
                if (! is_iterable($records)) {
                    return;
                }

                $count = 0;

                foreach ($records as $record) {
                    if ($record instanceof SchedaContract) {
                        if (app(SendMailByRecord::class)->execute($record, $this->template)) {
                            $count++;
                        }
                    }
                }
                // Mostra notifica di Filament con il numero di email inviate
                FilamentNotification::make()
                    ->title('Operazione completata')
                    ->body("Sono state inviate $count email.")
                    ->success()
                    ->send();
            });
    }
}

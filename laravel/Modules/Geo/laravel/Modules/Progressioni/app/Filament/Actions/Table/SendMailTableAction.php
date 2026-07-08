<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Actions\Table;

use Filament\Actions\Action;

class SendMailTableAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('')
            ->tooltip('send mail')
            ->openUrlInNewTab()
            ->icon('fas-mail-bulk')
            ->action(function ($record) {
                dddx(
                    [
                        'record' => $record,
                    ]
                );
            });
    }
}

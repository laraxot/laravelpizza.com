<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ScheduleResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ScheduleInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'command' => TextEntry::make('command'),
            'command_custom' => TextEntry::make('command_custom'),
            'params' => TextEntry::make('params'),
            'options' => TextEntry::make('options'),
            'options_with_value' => TextEntry::make('options_with_value'),
            'expression' => TextEntry::make('expression'),
            'even_in_maintenance_mode' => TextEntry::make('even_in_maintenance_mode'),
            'without_overlapping' => TextEntry::make('without_overlapping'),
            'on_one_server' => TextEntry::make('on_one_server'),
            'webhook_before' => TextEntry::make('webhook_before'),
            'webhook_after' => TextEntry::make('webhook_after'),
            'email_output' => TextEntry::make('email_output'),
            'sendmail_error' => TextEntry::make('sendmail_error'),
            'sendmail_success' => TextEntry::make('sendmail_success'),
            'log_success' => TextEntry::make('log_success'),
            'log_error' => TextEntry::make('log_error'),
            'status' => TextEntry::make('status'),
            'run_in_background' => TextEntry::make('run_in_background'),
            'log_filename' => TextEntry::make('log_filename'),
            'environments' => TextEntry::make('environments'),
        ];
    }
}

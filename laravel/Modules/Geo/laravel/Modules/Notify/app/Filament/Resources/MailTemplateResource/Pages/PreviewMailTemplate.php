<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\MailTemplateResource\Pages;

use Filament\Actions\Action;
use Modules\Notify\Filament\Resources\MailTemplateResource;
use Modules\Notify\Models\MailTemplate;
use Modules\Xot\Filament\Resources\Pages\XotBaseResourcePage;

/**
 * @property MailTemplate $record
 */
class PreviewMailTemplate extends XotBaseResourcePage
{
    protected static string $resource = MailTemplateResource::class;

    protected string $view = 'notify::filament.resources.mail-template-resource.pages.preview-mail-template';

    public function getTitle(): string
    {
        return __('notify::mail.template.preview.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('notify::mail.template.preview.actions.back.label'))
                ->icon(__('notify::mail.template.preview.actions.back.icon'))
                ->color(__('notify::mail.template.preview.actions.back.color'))
                ->url(fn () => MailTemplateResource::getUrl('edit', ['record' => $this->record])),
        ];
    }
}

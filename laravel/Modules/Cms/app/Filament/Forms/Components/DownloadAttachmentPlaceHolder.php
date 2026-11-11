<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Forms\Components;

use Illuminate\Support\HtmlString;
use Modules\Cms\Models\Attachment;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Forms\Components\XotBaseTextEntry;
use Webmozart\Assert\Assert;

class DownloadAttachmentPlaceHolder extends XotBaseTextEntry
{
    protected function setUp(): void
    {
        parent::setUp();
        // `Placeholder::content()` accettava un HtmlString e lo rendeva come HTML;
        // `TextEntry::state()` no, serve `html()` esplicito.
        $this->label('')->html()->state($this->generateContent(...))->columnSpanFull();
    }

    protected function generateContent(): HtmlString
    {
        $name = $this->getName();
        $attachment = Attachment::firstWhere('slug', $name);
        Assert::isInstanceOf($attachment, Attachment::class);

        $title = SafeStringCastAction::cast($attachment->title);
        $description = SafeStringCastAction::cast($attachment->description);
        $asset = SafeStringCastAction::cast($attachment->asset());

        $html = sprintf(
            '<a href="%s" class="underline" target="_blank" rel="noopener noreferrer">%s</a>%s',
            htmlspecialchars($asset, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($title, ENT_QUOTES, 'UTF-8'),
            $description !== ''
                ? '<div class="text-sm text-gray-600">'.htmlspecialchars($description, ENT_QUOTES, 'UTF-8').'</div>'
                : ''
        );

        return new HtmlString($html);
    }
}

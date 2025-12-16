<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Forms\Components;

use Illuminate\Support\HtmlString;
use Modules\Cms\Models\Attachment;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Forms\Components\XotBasePlaceholder;
use Webmozart\Assert\Assert;

class DownloadAttachmentPlaceHolder extends XotBasePlaceholder
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->label('')->content($this->generateContent(...))->columnSpanFull();
    }

    protected function generateContent(): HtmlString
    {
        $name = $this->getName();
        $attachment = Attachment::firstWhere('slug', $name);
        Assert::isInstanceOf($attachment, Attachment::class);

        $title = SafeStringCastAction::cast($attachment->title);
        $description = SafeStringCastAction::cast($attachment->description);
        /* @phpstan-ignore-next-line method.notFound */
        $asset = SafeStringCastAction::cast($attachment->asset());

        $html = sprintf(
            '<a href="%s" class="underline" target="_blank" rel="noopener noreferrer">%s</a>%s',
            htmlspecialchars($asset, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($title, ENT_QUOTES, 'UTF-8'),
            '' !== $description
                ? '<div class="text-sm text-gray-600">'.htmlspecialchars($description, ENT_QUOTES, 'UTF-8').'</div>'
                : ''
        );

        return new HtmlString($html);
    }
}

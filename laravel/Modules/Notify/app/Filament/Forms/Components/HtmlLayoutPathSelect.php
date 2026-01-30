<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\File;
use Modules\Xot\Datas\XotData;

class HtmlLayoutPathSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $xot = XotData::make();
        $path = $xot->getMailHtmlLayoutPath();

        $files = File::files($path);
        $options = [];
        foreach ($files as $file) {
            if ($file->getExtension() !== 'html') {
                continue;
            }
            $options[$file->getFilename()] = $file->getFilename();
        }

        $this
            ->options($options)
            ->required();
    }

    /**
     * Create a new MailTemplateSelect instance.
     *
     * @param  string|null  $name  Field name (default: 'mail_template_slug')
     */
    public static function make(?string $name = null): static
    {
        $name = $name ?? 'html_layout_path';

        return parent::make($name);
    }
}

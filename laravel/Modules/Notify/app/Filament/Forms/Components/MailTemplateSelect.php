<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Forms\Components;

use Modules\Notify\Models\MailTemplate;
use Modules\Xot\Filament\Forms\Components\XotBaseSelect;

class MailTemplateSelect extends XotBaseSelect
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->options(
                /** @return array<string, string> */
                fn (): array => MailTemplate::query()
                    ->orderBy('slug')
                    ->pluck('slug', 'slug')
                    ->all()
            )
            ->required();
    }

    /**
     * Create a new MailTemplateSelect instance.
     *
     * @param  string|null  $name  Field name (default: 'mail_template_slug')
     */
    public static function make(?string $name = null): static
    {
        $name = $name ?? 'mail_template_slug';

        return parent::make($name);
    }
}

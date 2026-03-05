<?php

declare(strict_types=1);

use Modules\Seo\Filament\Widgets\SocialShareWidget;
use Tests\TestCase;

uses(TestCase::class);

it('builds social links and exposes platforms in widget view data', function (): void {
    $widget = new class extends SocialShareWidget {
        public function exposeViewData(): array
        {
            return $this->getViewData();
        }
    };

    $widget->data = [
        'url' => 'https://example.test/page',
        'title' => 'Share Me',
    ];

    $viewData = $widget->exposeViewData();

    expect($viewData)->toHaveKeys(['links', 'platforms', 'data'])
        ->and($viewData['links'])->toHaveKeys(['facebook', 'twitter', 'linkedin', 'whatsapp', 'telegram', 'copy'])
        ->and($viewData['links']['copy'])->toBe('https://example.test/page')
        ->and($viewData['platforms'])->toContain('facebook');
});

it('returns empty form schema', function (): void {
    $widget = new SocialShareWidget;

    expect($widget->getFormSchema())->toBe([]);
});

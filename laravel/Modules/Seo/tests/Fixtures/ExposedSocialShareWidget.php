<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Fixtures;

use Modules\Seo\Filament\Widgets\SocialShareWidget;

/**
 * SocialShareWidget che espone getViewData() ai test (classe con nome, non anonima).
 */
final class ExposedSocialShareWidget extends SocialShareWidget
{
    /**
     * @return array<string, mixed>
     */
    public function exposeViewData(): array
    {
        return $this->getViewData();
    }
}

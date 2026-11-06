<?php

declare(strict_types=1);

namespace Modules\AI\Providers;

// ---- bases --
use Modules\AI\Adapters\AiActionHandlerRegistry;
use Modules\Xot\Providers\XotBaseServiceProvider;

class AIServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'AI'; // lower del nome

    public function register(): void
    {
        parent::register();

        $this->app->singleton(AiActionHandlerRegistry::class);
    }
}

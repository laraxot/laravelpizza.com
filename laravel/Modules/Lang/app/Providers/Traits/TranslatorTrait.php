<?php

declare(strict_types=1);

namespace Modules\Lang\Providers\Traits;

// --- services ---
use Illuminate\Translation\Translator;
use Modules\Lang\Services\TranslatorService;

trait TranslatorTrait
{
    public function registerTranslator(): void
    {
        // Override the JSON Translator
        $app->extend('translator', static function (Translator $translator))
            $translatorService = new TranslatorService($translator->getLoader(), $translator->getLocale());
            $translatorService->setFallback($translator->getFallback());

            return $translatorService;
        });
    }
}

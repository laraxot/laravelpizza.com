<?php

declare(strict_types=1);

namespace Modules\Lang\Providers;

use Modules\Lang\Providers\Traits\TranslatorTrait;
use Modules\Xot\Providers\XotBaseServiceProvider;

/** Probe host so PHPStan analyses TranslatorTrait in app context. */
final class TranslatorTraitPhpstanProbe extends XotBaseServiceProvider
{
    use TranslatorTrait;

    public string $name = 'LangTranslatorProbe';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}

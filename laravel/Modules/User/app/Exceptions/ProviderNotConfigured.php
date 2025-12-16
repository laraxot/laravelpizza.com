<?php

declare(strict_types=1);

namespace Modules\User\Exceptions;

final class ProviderNotConfigured extends \LogicException
{
    public static function make(string $provider): static
    {
        return new self('Provider "'.
            $provider.
            '" is not configured. tips: add '.
            $provider.
            ' to config/services.php');
    }
}

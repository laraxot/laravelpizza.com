<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_replace;

class NormalizePhoneNumberAction
{
    use QueueableAction;

    /**
     * Normalizes a phone number to a consistent format (e.g., E.164).
     *
     * @param  string|null  $phoneNumber  The phone number to normalize.
     * @return string Normalized phone number, or empty string if invalid/null.
     */
    public function execute(?string $phoneNumber): string
    {
        if ($phoneNumber === null || $phoneNumber === '') {
            return '';
        }

        // Remove any non-digit characters
        $normalized = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Ensure normalized is a string after preg_replace
        if (! is_string($normalized)) {
            return '';
        }

        // Ensure it starts with a '+' for E.164, assuming international format
        if (str_starts_with($normalized, '00')) {
            $normalized = '+'.substr($normalized, 2);
        } elseif (str_starts_with($normalized, '0')) {
            // Assuming local number starting with 0, needs country code.
            // This is a simplified example; a real implementation would need country context.
            // For now, let's just prepend '+' if it's missing and not a '00' or already '+'
            if (! str_starts_with($normalized, '+')) {
                // This is a placeholder for proper internationalization.
                // In a real app, you'd integrate with a library like libphonenumber-for-php
                // and have a default country code.
                $normalized = '+39'.$normalized; // Assuming Italy for example
            }
        } elseif (! str_starts_with($normalized, '+')) {
            $normalized = '+'.$normalized;
        }

        return SafeStringCastAction::cast($normalized);
    }
}

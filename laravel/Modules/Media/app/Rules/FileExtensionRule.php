<?php

declare(strict_types=1);

namespace Modules\Media\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

use function in_array;

class FileExtensionRule implements ValidationRule
{
    /** @var list<string> */
    protected array $validExtensions = [];

    /**
     * @param  array<int, string>  $validExtensions
     */
    public function __construct(array $validExtensions = [])
    {
        $this->validExtensions = array_values(array_map(
            static fn (string $extension): string => mb_strtolower($extension),
            $validExtensions,
        ));
    }

    /**
     * `mixed $value` imposto da `Illuminate\Contracts\Validation\ValidationRule` (LSP).
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->passes($attribute, $value)) {
            return;
        }

        $fail($this->message());
    }

    /**
     * @param  string  $attribute  The attribute being validated (not used in this rule)
     * @param  mixed  $value  The uploaded file to validate
     */
    public function passes(string $attribute, mixed $value): bool
    {
        if (! $value instanceof UploadedFile) {
            return false;
        }

        return in_array(mb_strtolower($value->getClientOriginalExtension()), $this->validExtensions, strict: true);
    }

    public function message(): string
    {
        $message = trans('media::validation.mime', [
            'mimes' => implode(', ', $this->validExtensions),
        ]);

        if (is_string($message)) {
            return $message;
        }

        if (is_array($message)) {
            foreach ($message as $translation) {
                if (is_string($translation)) {
                    return $translation;
                }
            }
        }

        return 'The file extension is not allowed.';
    }
}

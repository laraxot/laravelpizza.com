<?php

declare(strict_types=1);

namespace Modules\Media\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

use function in_array;

class FileExtensionRule implements Rule
{
    /** @var list<string> */
    protected array $validExtensions = [];

    /**
     * @param  list<string>  $validExtensions
     */
    public function __construct(array $validExtensions = [])
    {
        $this->validExtensions = array_values(array_map(
            /**
             * @return lowercase-string
             */
            static fn (string $ext): string => mb_strtolower($ext),
            $validExtensions
        ));
    }

    /**
     * @param  string  $attribute  The attribute being validated (not used in this rule)
     * @param  mixed  $value  The uploaded file to validate
     */
    public function passes($attribute, $value): bool
    {
        if (! $value instanceof UploadedFile) {
            return false;
        }

        return in_array(mb_strtolower($value->getClientOriginalExtension()), $this->validExtensions, strict: false);
    }

    /**
     * @return array<int|string, mixed>|string
     */
    public function message(): array|string
    {
        return trans('media::validation.mime', [
            'mimes' => implode(', ', $this->validExtensions),
        ]);
    }
}

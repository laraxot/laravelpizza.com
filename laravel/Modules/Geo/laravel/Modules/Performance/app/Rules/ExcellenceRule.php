<?php

declare(strict_types=1);

namespace Modules\Performance\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExcellenceRule implements Rule
{
    private string $msg = 'Eccellente si può dare solo a chi ha avuto il massimo.';

    /**
     * @return void
     */
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        $tot = request()->input('totale_punteggio');

        return ($value === 1 & $tot !== 100) === 0;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return $this->msg;
    }
}

<?php

declare(strict_types=1);

namespace Modules\Xot\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

/**
 * Class DateTimeRule.
 */
class DateTimeRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute  The attribute name being validated
     * @param  mixed  $value  The value being validated
     */
    public function passes($attribute, $value): bool
    {
        // dddx($attribute); //published_at
        // dddx($value); //10/10/2019 13:43
        // return 5 === strlen($value);

        if (! is_string($value)) {
            return false;
        }

        $format = 'd/m/Y H:i';
        try {
            $value_new = Carbon::createFromFormat($format, $value);
        } catch (Exception) {
            return false;
        }

        /* -- non fa il suo dovere --
         * request()->replace([$attribute=>$value_new]);
         */

        return true;
    }

    public function message(): string
    {
        return 'The :attribute is not a valid datetime';

        //    return trans('validation.only_uppercase');
    }
}

/*
 * class MyClassRequest extends FormRequest
 * {
 * ...
 * public function validationData() {
 * return array_merge(
 * $this->all(),
 * [
 * 'number' => preg_replace("/[^0-9]/", "", $this->number)
 * ]
 * );
 * }
 * ...
 * }
 *
 *
 * public function rules(Request $request)
 * {
 * if ($request->has('start_dt')){
 * $request->replace('start_dt', Carbon::createFromFormat('d M Y H:i:s', $request->start_dt . ' ' . $request->start_hr . ':'. $request->start_min . ':00'));
 * }
 *
 * if ($request->has('end_dt')){
 * $request->replace('end_dt' ,Carbon::createFromFormat('d M Y H:i:s', $request->end_dt . ' ' . $request->end_hr . ':'. $request->end_min . ':00'));
 * }
 *
 * return [
 * 'start_dt' => 'required|date|after:yesterday',
 * 'end_dt' => 'required|date|after:start_dt|before:' . Carbon::parse($request->start_dt)->addDays(30)
 * ];
 * }
 *
 *
 */

/*
 *
 * use Illuminate\Foundation\Http\FormRequest;
 *
 * class StorePostRequest extends FormRequest
 * {
 * public function rules()
 * {
 * return [
 * 'title' => 'required|max:200',
 * 'body' => 'required',
 * 'tags' => 'required|array|max:10',
 * 'is_published' => 'required|boolean',
 * 'author_name' => 'required',
 * ];
 * }
 *
 * protected function prepareForValidation()
 * {
 * $this->merge([
 * 'title' => fix_typos($this->title),
 * 'body' => filter_malicious_content($this->body),
 * 'tags' => convert_comma_separated_values_to_array($this->tags),
 * 'is_published' => (bool) $this->is_published,
 * ]);
 * }
 * }
 *
 *
 */

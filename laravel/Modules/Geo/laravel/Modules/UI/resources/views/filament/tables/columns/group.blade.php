<?php

declare(strict_types=1);

    $fields = $getFields();
    $record = $getRecord();
?>
<div
    {{
        $attributes
            ->merge($getExtraAttributes(), escape: false)
            ->class([
                'fi-ta-icon flex flex-wrap gap-1.5',
                'px-3 py-4' => ! $isInline(),
                //'flex-col' => $isListWithLineBreaks(),
                'flex-col' => true,
            ])
    }}
>
    @foreach ($fields as $field)
     
        @php
            $name = $field->getName();
            $value = $record->{$name} ?? null;
            // Skip empty values to save space
            if (empty($value) && $value !== 0 && $value !== '0') {
                continue;
            }

            // Format the value for display
            $formattedValue = $value;

            // Resolve the label leveraging LangServiceProvider auto translations
            $rawLabel = $field->getLabel();

            if ($rawLabel instanceof \Closure) {
                $rawLabel = $rawLabel($record);
            }

            if ($rawLabel instanceof \Illuminate\Contracts\Support\Htmlable) {
                $labelText = trim(strip_tags($rawLabel->toHtml()));
            } elseif (is_string($rawLabel)) {
                $labelText = trim($rawLabel);
            } else {
                $labelText = '';
            }

            if ($labelText === '') {
                $translationKey = 'ui::table.columns.' . $name . '.label';
                $translated = __($translationKey);
                $labelText = $translated !== $translationKey
                    ? $translated
                    : \Illuminate\Support\Str::of((string) $name)->replace('_', ' ')->headline()->value();
            }

            $displayText = $labelText . ': ' . $formattedValue;
        @endphp
        
            {{ $displayText }}<br/>
        
        
    @endforeach
</div>

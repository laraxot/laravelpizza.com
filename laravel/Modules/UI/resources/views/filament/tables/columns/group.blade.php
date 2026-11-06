@php
    declare(strict_types=1);

    use Filament\Tables\Columns\ColorColumn;
    use Filament\Tables\Columns\IconColumn;
    use Filament\Tables\Columns\ImageColumn;
    use Filament\Tables\Columns\SelectColumn;
    use Filament\Tables\Columns\TextColumn;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Str;

    $fields = $getFields();
    $record = $getRecord();
@endphp
<div
    {{
        $attributes
            ->merge($getExtraAttributes(), escape: false)
            ->class([
                'fi-ta-group flex flex-col gap-1',
                'px-3 py-4' => ! $isInline(),
            ])
    }}
>
    @foreach ($fields as $field)
        @php
            // Children live only in GroupColumn::$schema — mount table + record
            // or getState()/toEmbeddedHtml() throw "column is not mounted to a table".
            if (isset($getTable) && is_callable($getTable)) {
                $field->table($getTable());
            }

            if ($record instanceof Model || is_array($record)) {
                $field->record($record);
                $field->clearCachedState();
            }

            if (method_exists($field, 'isHidden') && $field->isHidden()) {
                continue;
            }

            $name = $field->getName();
            $value = $field->getState();
            if ($value === null) {
                $value = data_get($record, $name);
            }

            $isInteractiveColumn = $field instanceof SelectColumn;

            $isVisualColumn = $field instanceof IconColumn
                || $field instanceof ColorColumn
                || $field instanceof ImageColumn;

            // Interactive path: always render (select also when valutatore_id is null).
            // Text path: skip empties (keep 0 / '0'). Visual path: only skip null —
            // boolean false / 0 must still render the false icon.
            if (! $isInteractiveColumn) {
                if ($isVisualColumn) {
                    if ($value === null) {
                        continue;
                    }
                } elseif (empty($value) && $value !== 0 && $value !== '0') {
                    continue;
                }
            }

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
                $translationKey = 'ui::table.columns.'.$name.'.label';
                $translated = __($translationKey);
                $labelText = $translated !== $translationKey
                    ? $translated
                    : Str::of((string) $name)->replace('_', ' ')->headline()->value();
            }

            $displayValue = $value;
            $isHtmlValue = false;
            if ($field instanceof TextColumn && method_exists($field, 'formatState')) {
                $displayValue = $field->formatState($value);
                $isHtmlValue = $field->isHtml();
            }

            // PHP 8.4: enum/oggetti senza __toString() non possono essere castati in stringa da Blade.
            if ($displayValue instanceof \UnitEnum) {
                $enumLabel = $displayValue instanceof \Filament\Support\Contracts\HasLabel
                    ? $displayValue->getLabel()
                    : ($displayValue instanceof \BackedEnum ? $displayValue->value : $displayValue->name);
                $displayValue = $enumLabel instanceof \Illuminate\Contracts\Support\Htmlable
                    ? $enumLabel->toHtml()
                    : (string) $enumLabel;
            } elseif (is_object($displayValue) && ! method_exists($displayValue, '__toString')) {
                $displayValue = $displayValue::class;
            }
        @endphp

        @if ($isInteractiveColumn)
            <div class="fi-ta-group-row flex flex-nowrap items-center gap-1.5">
                <span class="fi-ta-group-label shrink-0 text-sm text-gray-500 dark:text-gray-400">{{ $labelText }}:</span>
                <span class="fi-ta-group-interactive inline-flex shrink-0 items-center">
                    {!! $field->toEmbeddedHtml() !!}
                </span>
            </div>
        @elseif ($isVisualColumn)
            {{-- Own row; label + icon stay on ONE line (IconColumn embeds a block div). --}}
            <div class="fi-ta-group-row flex flex-nowrap items-center gap-1.5">
                <span class="fi-ta-group-label shrink-0 text-sm text-gray-500 dark:text-gray-400">{{ $labelText }}:</span>
                <span class="fi-ta-group-visual inline-flex shrink-0 items-center [&_.fi-ta-icon]:inline-flex [&_.fi-ta-icon]:w-auto">
                    {!! $field->toEmbeddedHtml() !!}
                </span>
            </div>
        @else
            <div class="fi-ta-group-row text-sm break-words">
                <span class="fi-ta-group-label text-gray-500 dark:text-gray-400">{{ $labelText }}:</span>
                @if ($isHtmlValue)
                    <span class="fi-ta-group-value">{!! $displayValue !!}</span>
                @else
                    <span class="fi-ta-group-value"> {{ $displayValue }}</span>
                @endif
            </div>
        @endif
    @endforeach
</div>

@php
    $getId = $getId ?? fn () => null;
    $getLivewireSubmitHandler = $getLivewireSubmitHandler ?? fn () => null;
    $getExtraAttributes = $getExtraAttributes ?? fn () => [];
    $isDense = $isDense ?? fn () => false;
    $getChildSchema = $getChildSchema ?? fn () => new \Illuminate\Support\HtmlString('');
    $schemaComponent = $schemaComponent ?? null;
@endphp
<form
    {{
        $attributes
            ->merge([
                'id' => $getId(),
                'wire:submit' => $getLivewireSubmitHandler(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
            ->class([
                'fi-sc-form',
                'fi-dense' => $isDense(),
            ])
    }}
>
    {{ $getChildSchema($schemaComponent ? $schemaComponent::HEADER_SCHEMA_KEY : 'header') }}

    {{ $getChildSchema() }}

    {{ $getChildSchema($schemaComponent ? $schemaComponent::FOOTER_SCHEMA_KEY : 'footer') }}
</form>

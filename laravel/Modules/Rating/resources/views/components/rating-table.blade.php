{{-- Componente blade riutilizzabile per tabella rating. --}}
{{-- Usage: <x-rating-table :row="$row" /> --}}
{{-- Opzioni: --}}
{{--   $showNote  => true,  --}}
{{--   $rowspan    => true, --}}
{{--   $alignValue => 'right' --}}

@php
    $showNote = $showNote ?? true;
    $rowspan  = $rowspan ?? true;
    $alignValue = $alignValue ?? 'right';
    $note = '';
@endphp

<table class="rating-table">
    <colgroup>
        <col style="width: 55%">
        <col style="width: 15%">
        <col style="width: 15%">
        @if($showNote)
            <col style="width: 15%">
        @endif
    </colgroup>
    @foreach($row->ratings as $rating)
        <tr>
            <td>{!! $rating->getTxtHtml() !!}</td>
            <td align="{{ $alignValue }}">
                <b>{!! $rating->getValueHtml() !!}</b>
            </td>
            @php
                $note .= $rating->getNoteHtml() ?? '';
            @endphp
            @if($showNote && $loop->last)
                <td align="{{ $alignValue }}" rowspan="{{ $loop->count }}" style="vertical-align: middle; text-align: center;">
                    <span>{!! $note !!}</span>
                </td>
            @endif
        </tr>
    @endforeach
</table>

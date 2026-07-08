s([
    'title',
    'description', 
    'range'
])

<tr class="evaluation-section {{ $attributes->get('class') }}">
    <td rowspan="4" class="evaluation-title">
        <b>{{ $title }}</b>
    </td>
    <td class="evaluation-description">
        {{ $description }}
    </td>
    <td class="evaluation-range">
        {{ $range }}
    </td>
</tr>
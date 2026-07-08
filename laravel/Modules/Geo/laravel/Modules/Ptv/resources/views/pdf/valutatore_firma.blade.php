<table  style="width:80%;">
    <col style="width: 40%;" />
    <col style="width: 40%" />
    <tr>
        <td>
           Treviso, li
    @if ($row->updated_at != '')
        {{ $row->updated_at->format('d/m/Y') }}
    @else
        {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    @endif
        </td>
        <td>
            Dirigente: {{ $row->valutatore?->nome_diri }}
        </td>
    </tr>
</table>
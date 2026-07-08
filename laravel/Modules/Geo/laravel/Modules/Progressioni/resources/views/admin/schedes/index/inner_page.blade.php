//dddx(get_defined_vars());
//dddx($row->count());
$scheda = $rows->first();
if ($scheda == null) {
    echo '<h3>Seleziona un Valutatore</h3>';
    return;
}
@endphp
<table class="table">
    <tr>
        <td>Budget Assegnato</td>
        <td align="right">{{ number_format($scheda->valutatore->budget, 2) }}</td>
    </tr>
    <tr>
        <td>Budget Utilizzato</td>
        <td align="right">{{ number_format($scheda->valutatore->budgetAssegnato(), 2) }}</td>
    </tr>
    <tr>
        <td>Benificiari Progressione</td>
        <td align="right">{{ $scheda->valutatore->benificiariProgressione->count() }}</td>
    </tr>
</table>

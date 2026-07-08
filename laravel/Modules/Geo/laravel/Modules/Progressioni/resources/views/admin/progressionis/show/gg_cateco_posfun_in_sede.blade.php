if ($scheda == null) {
    //dddx(get_class($anag));
    echo '<h3>Utente non presente [' . $parz['matr'] . ']' . $anag->cognome . ' ' . $anag->nome . ' per anno ' . $parz['anno'] . '</h3>';

    return;
}
$lista_propro = $scheda->categoriaPropro->lista_propro;
$lista_propro_sup = $scheda->categoriaPropro->lista_propro_sup;

@endphp
<h2>giorni categoria eco / posfun in sede [qua00f][{{ $scheda->categoria_ecoval }}{{ $scheda->posfun }}] </h2>
<h4>
    lista propro : {{ $lista_propro }}<br />
    lista_propro_sup : {{ $lista_propro_sup }}<br />
</h4>

<table class="table table-striped table-bordered ">
    <thead>
        <tr>
            <td>id</td>
            <td>propro</td>
            <td>categoria eco</td>
            <td>posfun</td>
            <td>dal</td>
            <td>al</td>
            <td>gg</td>
        </tr>
    </thead>
    <tbody>
        @php
            $tot = 0;
        @endphp
        @foreach ($anag->qua00f()->orderBy('qua2kd')->get()
    as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->propro }}</td>
                <td>{{ $row->categoria_eco }}</td>
                <td>{{ $row->posfun }}</td>
                <td>{{ $row->qua2kd }}</td>
                <td>{{ $row->qua2ka }}</td>
                @php
                    $curr = $row->gg([
                        'date_max' => $date_max,
                        'date_min' => $date_min,

                        'lista_propro' => $scheda->categoriaPropro->lista_propro,
                        //'lista_propro_sup'=>$scheda->categoriaPropro->lista_propro_sup,
                        'posfun' => $scheda->posfun,
                    ]);
                    $tot += $curr;
                @endphp
                <td align="right">{{ $curr }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="6">TOT</th>
            <td align="right"><b>{{ $tot }}</b></td>
        </tr>
    </tbody>
</table>

iorni Assenze categoria eco / posfun In sede [asz00k1]
    [{{ $scheda->categoriaPropro->lista_propro }}]</h2>
[lista assenze: {{ $lista_codici_aspettative }}]<br />
[dal:{{ $date_min }}][al:{{ $date_max }}]



<table class="table table-striped table-bordered ">
    <thead>
        <tr>
            <td>id</td>
            <td>tipo - codice</td>

            <td>propro - posfun</td>

            <td>dal</td>
            <td>al</td>
            <td>gg</td>
        </tr>
    </thead>
    <tbody>
        @php
            $tot = 0;
            $aspettative = $anag
                ->asz00k1()
                ->ofListaTipoCodice($lista_codici_aspettative)
                ->get();
        @endphp
        @foreach ($aspettative as $row)

            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->asztip }}-{{ $row->aszcod }}
                    <br/>{{ $row->asz_descr }}
                </td>

                <td>{{ $row->propro }} - {{ $row->posfun }}
                    <br/>{{ $row->posizione_eco }}
                </td>
                {{-- <td>{{ $row->categoria_eco }}</td> --}}

                <td>{{ $row->asz2kd }}</td>
                <td>{{ $row->asz2ka }}</td>


                @php
                    $curr = $row->gg([
                        'date_min' => $date_min,
                        'date_max' => $date_max,
                        //,'propro'=>$schede->first()->propro
                        'lista_propro' => $scheda->categoriaPropro->lista_propro,
                        'posfun' => $scheda->posfun,
                    ]);
                    $tot += $curr;
                @endphp
                <td align="right">{{ $curr }}{{-- [{{ get_class($row) }}] Modules\Sigma\Models\Asz00k1 --}} </td>
                {{--  --}}
            </tr>

        @endforeach

        {{-- @foreach ($anag->gg_fuori_sede()->get() as $row)
		<tr>
			<td>{{ $row->id }}</td>
			<td>{{ $row->q3desc }} - {{ $row->q3tipo }}</td>
			<td>{{ $row->q3pro }}</td>
			<td>{{ $row->categoria_eco }}</td>
			<td>{{ $row->q3fun }}</td>
			<td>{{ $row->q32kd }}</td>
			<td>{{ $row->q32ka }}</td>
			@php
				$curr=	$row->gg(['date_max'=>$date_max,'date_min'=>$date_min
								//,'propro'=>$schede->first()->propro
								,'categoria_eco'=>$schede->first()->categoria_ecoval
								,'posfun'=>$schede->first()->posfun]);
				$tot+=$curr;
			@endphp
			<td align="right">{{ $curr }}</td>
		</tr>
	@endforeach --}}
        <tr>
            <th colspan="5">TOT</th>
            <td align="right"><b>{{ $tot }}</b></td>
        </tr>
    </tbody>
</table>

nds('adm_theme::layouts.app')
@section('content')
    <table class="table table-bordered">
        <tr>
            <td>Lavoratore <br />
                <a href="#">[{{ $row->id }}]</a>
                <a href="{{ Request::fullUrlWithQuery(['refresh' => 1]) }}" data-toggle="tooltip" title="ricalcola">
                    <i class="fas fa-sync"></i>
                </a>
            </td>
            <td>{{ $row->ente }}-{{ $row->matr }} <br />
                {{ $row->cognome }}-{{ $row->nome }}
            </td>
        </tr>
        <tr>
            <td>dal - al</td>
            <td>{{ $row->dal }}-{{ $row->al }}</td>
        </tr>
        <tr>
            <td>anno</td>
            <td>{{ $row->anno }}</td>
        </tr>
        <tr>
            <td>GG Assenze Anno</td>
            <td>{{ $row->gg_assenza_anno }}</td>
        </tr>
        <tr>
            <td>HH Assenze Anno</td>
            <td>{{ $row->hh_assenza_anno }}</td>
        </tr>

        <tr>
            <td>GG Assenze Dal Al</td>
            <td>{{ $row->gg_assenza_dalal }}</td>
        </tr>
        <tr>
            <td>HH Assenze dal al</td>
            <td>{{ $row->hh_assenza_dalal }}</td>
        </tr>
        <tr>
            <td>data ultima assunzione</td>
            <td>{{ $row->last_data_assunz }}</td>
        </tr>
        <tr>
            <td>ha_diritto</td>
            <td>{{ $row->ha_diritto }}</td>
        </tr>
        <tr>
            <td>motivo</td>
            <td>{{ $row->motivo }}</td>
        </tr>
    </table>

    @php
    //dddx(($row->criteriEsclusione));
    @endphp
    <h3>Criteri Esclusione</h3>
    <table class="table tablebordered">
        @foreach ($row->criteriEsclusione as $ce)
            @php
                //dddx($ce);
            @endphp
            <tr>
                <td>{{ $ce->name }}</td>
                <td>{{ $ce->value }}</td>
                <td>{{ $row->check($ce->name, $ce->value) }}</td>
            </tr>
        @endforeach
    </table>


    <h3>Asz00k1</h3>
    @php
    $lista_tipo_codice_assenze = $row->listaTipoCodiceAssenze();
    @endphp
    {{ $lista_tipo_codice_assenze }}
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>
                tipo - codice
            </th>
            <th>Dal</th>
            <th>Al</th>
            <th>Ora Inizio</th>
            <th>Ora Fine</th>
            <th>UMI</th>
            <th>Dur</th>
            <th>GG</th>
            <th>HH</th>
        </tr>
        @php
            $gg_tot = 0;
            $hh_tot = 0;
            $aszs = $row
                ->asz00k1()
                ->OfListaTipoCodice($lista_tipo_codice_assenze)
                ->ofYear($row->anno)
                ->get();
        @endphp
        @foreach ($aszs as $asz)
            @php
                $gg_curr = 0;
                $hh_curr = 0;
                if ($asz->aszumi == 'G') {
                    $gg_curr = $asz->aszdur;
                } else {
                    $hh_curr = $asz->aszdur;
                }
                $gg_tot += $gg_curr;
                if ($hh_curr != 0) {
                    [$h, $m] = explode('.', $hh_curr);
                    $hh_tot += ($h * 60 + $m) / 60;
                }
            @endphp
            <tr>
                <td>{{ $asz->id }}</td>
                <td>
                    {{ $asz->asztip }}-{{ $asz->aszcod }} <br />

                </td>
                <td>{{ $asz->asz2kd }}</td>
                <td>{{ $asz->asz2ka }}</td>
                <td>{{ $asz->aszini }}</td>
                <td>{{ $asz->aszfin }}</td>
                <td>{{ $asz->aszumi }}</td>

                <td align="right">{{ $asz->aszdur }} </td>
                <td align="right">{{ $gg_curr }}</td>
                <td align="right">{{ $hh_curr }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8"> TOT </td>
            <td align="right"><b>{{ $gg_tot }}</b></td>
            <td align="right"><b>{{ $hh_tot }}</b></td>
        </tr>
    </table>




@endsection

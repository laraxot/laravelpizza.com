e class="table table-striped table-bordered ">
    <thead></thead>
    <tbody>

        <tr>
            <td>[{{ $row->id }}] <a href="{{ Request::fullUrlWithQuery(['refresh' => 1]) }}"
                    data-toggle="tooltip" title="ricalcola">
                    <i class="fas fa-sync"></i>
                </a>
                <br />
                {{ $row->ente }}-{{ $row->matr }} <br />
                {{ $row->cognome }} {{ $row->nome }} <br />

                @php
                    //dddx($row->ha_diritto);
                    //return ;
                @endphp
                @if (!$row->ha_diritto)
                    ha diritto ? <span style="color:darkred;font-weight:800">NO</span><br />
                    motivo : {{ $row->motivo }}
                @else
                    ha diritto ? <span style="color:darkgreen;font-weight:800">SI</span><br />
                @endif
                <br />post type: {{ $row->post_type }}
                <br />gg_in_sede: {{ $row->gg_in_sede }}
                {{-- <br />gg_fuori_sede: {{ $row->gg_fuori_sede }}
                <br />gg: {{ $row->gg }}
                <br/>gg_presenza_anno :{{ $row->gg_presenza_anno }}
				<br/>gg_assenza_anno :{{ $row->gg_assenza_anno }}

				<br/>gg_cateco_in_sede:{{ $row->gg_cateco_in_sede }}
				<br/>gg_cateco_fuori_sede:{{ $row->gg_cateco_fuori_sede }}
				<br/>gg_cateco_posfun_in_sede :{{ $row->gg_cateco_posfun_in_sede }}
				<br/>gg_cateco_posfun_fuori_sede :{{ $row->gg_cateco_posfun_fuori_sede }}
				<br/>gg_aspettative_pond_in_sede :{{ $row->gg_aspettative_pond_in_sede }}
				<br/>gg_aspettative_pond_fuori_sede :{{ $row->gg_aspettative_pond_fuori_sede }} --}}

                <br />ptime :{{ $row->ptime }}
                <br />costo fascia up :{{ $row->costo_fascia_up }}

                <br />
                <b>Performance:</b>
                @for ($i = 1; $i <= 3; $i++)
                    <br />Anno: {{ $row->anno - $i }} : {{ $row->perfInd($row->anno - $i) }}
                @endfor
                <br /><b>Media</b>: {{ $row->perf_ind_media }}
                <br />
                <b>gg_cateco_sup_in_sede :</b>{{ $row->gg_cateco_sup_in_sede }}

                <br/>
                <b>CRITERI PRECEDENZA</b>
                @foreach ($row->criteriPrecedenza as $criteri)
                    <br />{{ $criteri->label }} : {{ $row->{$criteri->name} }}
                @endforeach
                <hr/>
                {{-- get_class($row)  // Modules\Progressioni\Models\Progressioni --}}
                punt_progressione_finale: {{ $row->punt_progressione_finale }}
                {{--
                <pre>
                {{ print_r($row->schedaCriteri->toArray(),true) }}
                </pre>
                --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Peso</th>
                            <th>Valore</th>
                            <th>Valore Conv</th>

                        </tr>
                    </thead>
                    @php
                        $punt=0;
                    @endphp
                    @foreach($row->schedaCriteri as $crit)
                        @php
                            $value_conv=$row->convertedIn($crit->field_name,(int)$crit->converted_in);
                            $peso=$crit->peso;
                            $punt+=$value_conv*$peso/10;
                        @endphp
                        <tr>
                            <td>{{ $crit->criterio }}<br/>
                                [{{ $crit->field_name }}]
                            </td>
                             <td align="right">
                                {{ $peso }}
                            </td>
                            <td align="right">
                                {{ $row->{$crit->field_name} }}
                            </td>
                            <td align="right">
                                {{ $value_conv }}
                            </td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="3">Tot</td>
                            <td colspan="1" align="right"><b>{{ $punt }}</b></td>
                        </tr>
                    </tfoot>
                </table>



                {{-- @php

					$parz=['stabi'=>$row->stabi,'repar'=>$row->repar,'anno'=>$row->anno,'id_pdf'=>$row->id];
					$route=route('progressioni.stabi_repar_anno.schede.pdfrow',$parz);
					//echo $route;
				@endphp
				<a class="btn btn-small btn-default" data-toggle="tooltip" title="Crea PDF" href="{{ $route }}"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i>&nbsp;PDF</a>
				@php
					$parz=['stabi'=>$row->stabi,'repar'=>$row->repar,'anno'=>$row->anno,'id_schede'=>$row->id];
					$route=route('progressioni.ctrlmatr.updaterow',$parz);
					//echo $route;
				@endphp
				<a class="btn btn-small btn-default" data-toggle="tooltip" title="Aggiorna Dati" href="{{ $route }}"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i>&nbsp;Aggiorna</a> --}}
                {{-- {!! Form::bsBtnEdit(['id_ctrlMatr'=>$row->id]) !!} --}}
            </td>
            <td>{{ $row->propro }}-{{ $row->posfun }}<br />
                {{ $row->categoria_eco }}</td>
            <td>{{ $row->posiz }} <br />
                {{ $row->posiz_txt }}</td>
            <td>{{ $row->stabi }} <br />
                {{ $row->stabi_txt }}</td>
            <td>{{ $row->repar }} <br />
                {{ $row->repar_txt }}
                {{-- {!! Form::bsOpen($row,'update') !!} --}}
                {{-- {{ Form::model($row,['route' => ['progressioni.ctrlmatr',$row->id] ]) }}
					{{ method_field('PUT') }}
					{!! csrf_field() !!}
					{{ Form::hidden('id') }}
					{{ Form::bsText('stabi') }}
					{{ Form::bsText('repar') }}
					{{ Form::bsText('ha_diritto') }}
					{{ Form::bsTextarea('motivo') }}
					{{ Form::bsSubmit('aggiorna') }}
				{{ Form::close() }}
				<small>{{ $row->updated_by }} at {{ $row->updated_at }}</small> --}}
            </td>
            <td>
                <table class="table table-striped table-bordered ">
                    <thead>
                        <tr>
                            <td>descr</td>
                            <td>q</td>
                            <td>peso</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $tot = 0;
                            $coeffs = $row
                                ->coeff()
                                ->where('value', '!=', 0)
                                ->get();
                            $i = 0;
                        @endphp
                        @foreach ($coeffs as $kc => $vc)
                            @php
                                $sk = $vc->name;
                                //if($i++>2) dddx('o');
                            @endphp
                            <tr>
                                <td>{{ $sk }}</td>

                                <td align="right">{{ $row->$sk }}</td>
                                <td align="right">{{ number_format($vc->value, 2) }}</td>
                                @php
                                    $curr = $row->$sk * $vc->value;
                                    $tot += $curr;
                                @endphp
                                <td align="right">{{ number_format($curr, 2) }}</td>

                            </tr>

                        @endforeach


                        <tr>
                            <td colspan="3"><b>Tot</b></td>
                            <td align="right"><b>{{-- number_format($row->gg_tot_pond,2) --}} {{ number_format($tot, 2) }}</b></td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table class="table table-striped table-bordered ">
                    <thead>
                        <td>descr</td>
                        <td>q</td>
                    </thead>
                    @php
                        $criteri_fields = $row->criteriEsclusioneFields();

                    @endphp
                    <tbody>
                        @foreach ($criteri_fields as $cri_field)
                            <tr>
                                <td>{{ $cri_field }}</td>

                                <td align="right">{{ $row->$cri_field }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- dddx('o') --}}
            </td>
        </tr>
    </tbody>
</table>

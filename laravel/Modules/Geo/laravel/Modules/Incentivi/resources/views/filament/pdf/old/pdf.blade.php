@include('ptv::pdf.css')
<page>

    <div>

        <img src="{{ public_path('assets/ptv/img/logo.png') }}">

        <div style="text-align: right">
            Treviso, {{ date('d-m-Y H:i:s', strtotime($project->updated_at)) }}
        </div>

        <h4 style=""> OGGETTO: {{ $project->nome }}
            <p class="">Descrizione: <span class=""><strong>{{ $project->oggetto }}</strong></span></p>
        </h4>

        
            <p style="text-align: center">
                Visto il regolamento per la disciplina delle modalità e dei criteri di ripartizione del fondo
                incentivante previsto dall'art. 113 del D.lgs. 50/2016 e s.m.i.;
            </p>
            <br>
            <p class="text-sm"> Vista la determinazione dirigenziale <strong>{{ $project->determina }}</strong>
                avente ad oggetto: <strong>{{ $project->oggetto }}</strong>
            </p>
            <p class="text-sm"> L'intervento in oggetto riguarda Appalti di <strong>{{ $project->tipo }}</strong>
                per un valore di <strong>{{ $project->importo_totale }} €</strong> per cui la
                percentuale applicabile per il calcolo del fondo è pari al <strong>{{ $project->percentuale_fondo }} %</strong>.
                L'incentivo previsto per i lavori in oggetto relativamente alla fase progettuale e alla fase di esecuzione e collaudo,
                ammonta a complessivi <strong>{{ $project->importo_effettivo_fondo }} €</strong>,
                da cui vengono dedotte la quota del 20% per il fondo per l'innovazione pari a <strong>{{ $project->componente_innovazione }} €</strong>
                e le quote per incarichi professionali esterni pari ad ???
                e di consequenza la somma liquidabile da ripartire internamente risulta pari a <strong>{{ $project->componente_incentivante }} €</strong>.
            </p>
            <p class="text-sm"> Sentito il RUP del procedimento in oggetto: <strong> {{ $rup }} </strong> </p>
            <p class="text-sm"> Visto il dispone del: <strong>{{ date('d-m-Y', strtotime($project->data_aggiudicazione)) }}</strong> </p>
            <p class="text-sm underline"> Attuate le corrette correzioni al gruppo di lavoro ed al lavoro eseguito
                dovute dalla dinamicità del progetto
            </p>

            <p style="text-align: center"> DISPONE </p>
            <p class="text-sm"> di approvare la liquidazione della fase di aggiudicazione del gruppo di lavoro e di
                ripartire la quota come indicato nelle tabelle allegate. </p>
            <br>

            <div style="text-align: right">
                <p>Il Dirigente del Settore {{ $project->settore }}</p>
            </div>

        </div>
        <br>



</page>




<page>

<h3> <strong> CALCOLO FONDO INCENTIVANTE {{ $project->tipo }}</strong> </h3>
        <p class="text-sm"> In conformità con l'ex articolo 45, D.LGS 36/2023 e in applicazione del regolamento
            approvato il 23/08/24. Protocollo 43254/2024 </p>

        <div class="pt-4">
            <table class="morpion" style="width:100%;border:1px solid gray;">
                <col style="width: 70%;font-size: 10px" class="col1" />
                <col style="width: 10%" />
                <col style="width: 20%" />

                <tr>
                    <th>Macroattività</th>
                    <th>%</th>
                    <th>Importo</th>
                </tr>

                <tr class="h-10">
                    <td>Importo dei lavori a base d'asta (art.5 comma 2).</td>
                    <td>/</td>
                    <td>{{ $project->importo_totale }} €</td>
                </tr>
                <tr class="h-10">
                    <td>Percentuale effettiva del fondo in base all'importo (art.5 comma 1).</td>
                    <td>{{ $project->percentuale_fondo }}</td>
                    <td>{{ $project->importo_effettivo_fondo }} €</td>
                </tr>
                <tr class="h-10">
                    <td>Fondo per l'innovazione</td>
                    <td>20</td>
                    <td>{{ $project->componente_innovazione }} €</td>
                </tr>
                <tr class="h-10">
                    <td>Componente Incentivante (art.4 comma 2)</td>
                    <td>80</td>
                    <td>{{ $project->componente_incentivante }} €</td>
                </tr>

            </table>

            <br>

            <table class="morpion" style="width:100%;border:1px solid gray;">
                <col style="width: 70%;font-size: 10px" class="col1" />
                <col style="width: 6%" />
                <col style="width: 12%" />
                <col style="width: 12%" />

                <tr>
                    <th>Descrizione</th>
                    <th>%</th>
                    <th>Importo</th>
                    <th>Anno competenza</th>
                </tr>

                 @foreach ($project->activities as $activity)
                    <tr class="h-10">
                        <td>{{ $activity->nome }}</td>
                        <td>{{ $activity->quota_percentuale }}</td>
                        <td>{{ $activity->importo }} €</td>
                        <td>{{ $activity->anno_competenza }}</td>
                    </tr>
                @endforeach

            </table>

        </div>

        <br>

</page>

<page>

<h3> <strong> FASE AGGIUDICAZIONE </strong> </h3>
        <div class="pt-4">
            @foreach ($project->activities as $activity)
                <h4><strong>{{ $activity->nome }}</strong></h4>
                <table class="morpion" style="width:100%;border:1px solid gray;">
                    
                    <col style="width: 20%;font-size: 10px" class="col1" />
                    <col style="width: 20%" />
                    <col style="width: 20%" />
                    <col style="width: 15%" />
                    <col style="width: 20%" />

                    <tr class="h-10 text-left">
                        <th>Matricola</th>
                        <th class="pr-4">Cognome</th>
                        <th class="pr-2">Nome</th>
                        <th class="pr-2">Percentuale</th>
                        <th>Importo</th>
                    </tr>

                    @foreach ($activity->employees as $employee)
                        <tr class="h-10">
                            <td>{{ $employee->matricola }}</td>
                            <td>{{ $employee->cognome }}</td>
                            <td>{{ $employee->nome }}</td>
                            <td>{{ $employee->pivot->percentuale_attivita_dipendente }} %</td>
                            <td>{{ $employee->pivot->importo_attivita_dipendente }} €</td>
                        </tr>
                    @endforeach

                </table>
                <br><br>
            @endforeach
        </div>

</page>



<page>
<h3> <strong> TOTALI DA LIQUIDARE - Fase di aggiudicazione </strong> </h3>
        <div class="pt-4">
            @foreach ($phases as $phase)
                <h4><strong>{{ $phase->name }}</strong> dal {{ date('d-m-Y', strtotime($phase->start_date)) }} al {{ date('d-m-Y', strtotime($phase->end_date)) }} </h4>
                {{-- <h4>{{ $phase->description }} </h4> --}}
                <table class="morpion" style="width:100%;border:1px solid gray;">
                    
                    <col style="width: 40%;font-size: 10px" class="col1" />
                    <col style="width: 20%" />

                    <tr class="h-10 text-left">
                        <th>Denominazione</th>
                        <th>Importo</th>
                    </tr>

                    @if ($phase->settlement)
                        <tr class="h-10">
                            <td>{{$phase->settlement->denominazione}}</td>
                            <td>€ {{ number_format($phase->settlement->importo, 2, ',', '.') }}</td>
                        </tr>
                    @else
                        <p> Nessuna liquidazione associata. <p/>
                    @endif

                </table>

                <br>

                @php
                $anni = $project->employees
                    ->flatMap(function ($employee) {
                        return $employee->activities->pluck('anno_competenza');
                    })
                    ->unique()
                    ->sort()
                    ->values();
                @endphp

                {{-- <h6>Totale Dipendenti di {{ $phase->name }} </h6> --}}
                <table class="morpion" style="width:100%;border:1px solid gray;">
                    <col style="width: 10%;font-size: 10px" class="col1" />
                    <col style="width: 15%" />
                    <col style="width: 15%" />
                    @foreach ($anni as $anno)
                        <col style="width: 10%" />
                    @endforeach
                    <col style="width: 10%" />

                    <tr class="h-10 text-left">
                        <th>Matricola</th>
                        <th class="pr-4">Cognome</th>
                        <th class="pr-2">Nome</th>
                        @foreach ($anni as $anno)
                            <th>{{ $anno }}</th>
                        @endforeach
                        <th>Totale</th>
                    </tr>

                    @foreach ($project->employees as $employee)
                        <tr class="h-10">
                            <td>{{ $employee->matricola }}</td>
                            <td>{{ $employee->cognome }}</td>
                            <td>{{ $employee->nome }}</td>
                            @foreach ($anni as $anno)
                                <td>
                                    @php
                                        $somma = $employee->activities
                                            ->where('anno_competenza', $anno)
                                            ->sum('importo');
                                    @endphp
                                    € {{ number_format($somma, 2, ',', '.') }}
                                </td>
                            @endforeach
                            <td> € {{ number_format($employee->activities->sum('importo'), 2, ',', '.') }} </td>
                        </tr>
                    @endforeach

                    <!-- Riga dei totali -->
                    <tr style="height: 40px; font-weight: bold; background-color: #f0f0f0; border-top: 2px solid #6b7280;">
                        <td colspan="3" style="text-align: left; font-weight: bold;">Totale</td>
                        @foreach ($anni as $anno)
                            <td>
                                @php
                                    $totalAnno = 0;
                                    foreach ($project->employees as $employee) {
                                        $totalAnno += $employee->activities
                                            ->where('anno_competenza', $anno)
                                            ->sum('importo');
                                    }
                                @endphp
                                € {{ number_format($totalAnno, 2, ',', '.') }}
                            </td>
                        @endforeach
                        <td>
                            @php
                                $grandTotal = 0;
                                foreach ($project->employees as $employee) {
                                    $grandTotal += $employee->activities->sum('importo');
                                }
                            @endphp
                            € {{ number_format($grandTotal, 2, ',', '.') }}
                        </td>
                    </tr>

                </table>

                <br><br>
            @endforeach


        </div>


    <br><br><br><br>


    <div class="pt-16 text-sm">
        <p class="font-bold"> <strong> Settore {{ $project->settore }} </strong> </p>
        <p>Responsabile del Procedimento: {{ $rup }} </p>
        <p>Via cal di Breda, 116 - 31100 Treviso- P.IVA 01138380264 C.F. 80008870265 </p>
        <p>PEC: protocollo.provincia.treviso@pecveneto.it - www.provincia.treviso.it </p>
    </div>


</page>
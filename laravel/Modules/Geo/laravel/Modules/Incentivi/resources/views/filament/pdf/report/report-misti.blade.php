@include('ptv::pdf.css')
<page>

    <div>

        @include('ptv::pdf.header')
        <br><br><br><br><br>

        <h4 style=""> OGGETTO: Individuazione del gruppo di lavoro relativo a {{ $project->oggetto }} </h4>

        <h4 style="text-align: center"> IL DIRIGENTE</h4>
        <p>
            Visto il regolamento per la disciplina delle modalità e dei criteri di ripartizione dell'incentivo
            previsto dall'art.45 del D.Lgs 36/2023, approvato con decreto Presidenziale n.36 del 16.2.2024, e successive modificazioni.
        </p>
        <br>
        <p class="text-sm"> Visto che con determina <strong>{{ $project->determina }}</strong>
            si è affidato ai sensi dell'art. 50, comma 1, lettera b) del D.Lgs 36/2023,
            <strong>{{ $project->nome }}</strong>
            alla Ditta <strong>{{ $project->ditta_nome }}</strong>
            con sede a <strong>{{ $project->ditta_sede }}</strong> - <strong>{{ $project->ditta_partita_iva }}</strong>,
            per complessivi Euro <strong>{{ $project->importo_totale }}</strong>.=, Iva esclusa, 
            di cui Euro <strong>{{ $project->ditta_oneri_sicurezza }}</strong>.= oneri di sicurezza,
            alle condizioni indicate nella trattativa n. <strong>{{ $project->ditta_trattativa }}</strong> e nel Foglio Oneri;
        </p>




        <p> Constatato che,</p>
        <br />
        <ul>
            <li>
                    L'affidamento in oggetto relativo all'appalto di <strong>{{ $project->tipo }} </strong>
                    {{-- per il primo perido contrattuale a far data 
                    <strong>{{ date('d-m-Y', strtotime($project->data_inizio_esecuzione)) }}</strong> - 
                    <strong>{{ date('d-m-Y', strtotime($project->data_fine_esecuzione)) }}</strong> , --}}
                    ha un importo a base d'asta di Euro <strong>{{ $project->importo_totale }}</strong>, e pertanto la percentuale incentivante è del <strong>{{ $project->percentuale_fondo }} %</strong>;
            </li>
            <li>
                    
                    Con la predetta determinazione è stata nominata RUP <strong>{{ $rup }}</strong>
                    e Direttore dell'esecuzione <strong>{{ $dec }}</strong>, 
                    come previsto dall'art.114, comma 8 del D.Lgs n. 36/2023 e dall'art.32, comma 2, Lett. m) dell'allegato II.14,
                    quale servizio di particolare importanza per qualità delle prestazioni;
                                
            </li>
        </ul>
        

        <p class="text-sm"> Visto che l'incentivo previsto per l'affidamento ammonta a Euro <strong>{{ $project->importo_effettivo_fondo }} </strong> ;</p>
        <p class="text-sm">
            Ritenuto di costituire, a norma dell'art.3 del vigente regolamento sopra richiamato il Gruppo di lavoro,
            individuando il personale che svolgerà le attività tecniche amministrative oggetto di incentivo funzioni tecniche per il predetto periodo contrattuale;
        </p>

        <br /><br />

        <p style="text-align: center"> DISPONE </p>
        <p class="text-sm">
            1. Di costituire il seguente gruppo di lavoro, relativamente al <strong>{{ $project->nome }}</strong>,
            {{-- per il periodo dal <strong>{{ date('d-m-Y', strtotime($project->data_inizio_esecuzione)) }}</strong>  --}}
            {{-- al <strong>{{ date('d-m-Y', strtotime($project->data_fine_esecuzione)) }}</strong>, --}}
            che potrà prevedere delle variazioni in caso di assenza e impedimento del personale individuato:
        </p>



        <div class="pt-4">
                    
            <table class="morpion" style="width:100%;border:1px solid gray;">
                
                <col style="width: 20%; font-size: 10px" class="col1" />
                <col style="width: 20%" />
                <col style="width: 50%" />

                <tr>
                    <th style="font-size: 16px; height: 30px">Cognome</th>
                    <th style="font-size: 16px; height: 30px">Nome</th>
                    <th style="font-size: 16px; height: 30px">Qualifica Profilo professionale</th>
                </tr>

                @foreach ($employees as $employee)
                    <tr>
                        <td style="font-size: 12px; height: 30px">{{ $employee->cognome }}</td>
                        <td style="font-size: 12px; height: 30px">{{ $employee->nome }}</td>
                        <td style="font-size: 12px; height: 30px">{{ $employee->tqu00f_desc2 }} </td>
                    </tr>
                @endforeach

            </table>
            <br><br>
        </div>




        <p class="text-sm">
            2. Di dare atto che la corresponsione delle somme spettanti al personale del gruppo di lavoro sopra individuato
            avverrà secondo le attività effettivamente svolte all'interno delle fasi di programmazione, progettazione e
            predisposizione atti di gara, esecuzione del contratto.
        </p>


    </div>

        

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
                    <th style="font-size: 16px; height: 30px">Macroattività</th>
                    <th style="font-size: 16px; height: 30px">%</th>
                    <th style="font-size: 16px; height: 30px">Importo</th>
                </tr>

                <tr class="h-10">
                    <td style="font-size: 12px; height: 30px">Importo dei lavori a base d'asta (art.5 comma 2).</td>
                    <td>/</td>
                    <td style="font-size: 12px; height: 30px">{{ $project->importo_totale }} €</td>
                </tr>
                <tr class="h-10">
                    <td style="font-size: 12px; height: 30px">Percentuale effettiva del fondo in base all'importo (art.5 comma 1).</td>
                    <td style="font-size: 12px; height: 30px">{{ $project->percentuale_fondo }}</td>
                    <td style="font-size: 12px; height: 30px">{{ $project->importo_effettivo_fondo }} €</td>
                </tr>
                <tr class="h-10">
                    <td style="font-size: 12px; height: 30px">Fondo per l'innovazione</td>
                    <td style="font-size: 12px; height: 30px">20</td>
                    <td style="font-size: 12px; height: 30px">{{ $project->componente_innovazione }} €</td>
                </tr>
                <tr class="h-10">
                    <td style="font-size: 12px; height: 30px">Componente Incentivante (art.4 comma 2)</td>
                    <td style="font-size: 12px; height: 30px">80</td>
                    <td style="font-size: 12px; height: 30px">{{ $project->componente_incentivante }} €</td>
                </tr>

            </table>

            <br>

            <table class="morpion" style="width:100%;border:1px solid gray;">
                <col style="width: 70%;font-size: 10px" class="col1" />
                <col style="width: 6%" />
                <col style="width: 12%" />
                <col style="width: 12%" />

                <tr>
                    <th style="font-size: 16px; height: 30px">Descrizione</th>
                    <th style="font-size: 16px; height: 30px">%</th>
                    <th style="font-size: 16px; height: 30px">Importo</th>
                    <th style="font-size: 14px; height: 30px">Anno competenza</th>
                </tr>

                 @foreach ($activities as $activity)
                    <tr class="h-10">
                        <td style="font-size: 12px; height: 30px">{{ $activity->nome }}</td>
                        <td style="font-size: 12px; height: 30px">{{ $activity->quota_percentuale }}</td>
                        <td style="font-size: 12px; height: 30px">{{ $activity->importo }} €</td>
                        <td style="font-size: 12px; height: 30px">{{ $activity->anno_competenza }}</td>
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
                <h4>
                    <strong>{{ $activity->nome }} </strong>
                    @if ($activity->employees->count() == 0)
                        (ATTIVITÀ NON SVOLTA)
                    @endif
                </h4>

                @if ($activity->employees->count() !== 0)
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
                                <td>
                                    {{ $employee->matricola }} 
                                    @if ($employee->tipologia === 'E')
                                        (CONSULENTE ESTERNO)
                                    @endif
                                </td>
                                <td>{{ $employee->cognome }}</td>
                                <td>{{ $employee->nome }}</td>
                                <td>{{ $employee->pivot->percentuale_attivita_dipendente }} %</td>
                                <td>{{ $employee->pivot->importo_attivita_dipendente }} €</td>
                            </tr>
                        @endforeach

                    </table>
                @endif

                <br><br>
            @endforeach
        </div>

</page>



{{-- <page>
<h3> <strong> TOTALI DA LIQUIDARE - Fase di aggiudicazione </strong> </h3>
        <div class="pt-4">
            @foreach ($phases as $phase)
                <h4><strong>{{ $phase->name }}</strong> dal {{ date('d-m-Y', strtotime($phase->start_date)) }} al {{ date('d-m-Y', strtotime($phase->end_date)) }} </h4>
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




</page> --}}


<br><br><br><br>

<p class="text-sm"> Treviso, {{ date('d-m-Y') }} </p>


<br><br>

<div style="text-align: left">
    <p> 
    Il Dirigente <br>
    {{ $stabiDirigente->nome_diri }}
    </p>
    <p style="font-size: 10px"> Il documento è firmato digitalmente ai sensi del D.Lgs. 82/2005 s.m.i. e norme collegate e sostituisce il documento cartaceo e la firma autografa.</p>
</div>



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
            il <strong>{{ $project->nome }}</strong>
            alla Ditta <strong>{{ $project->ditta_nome }}</strong>
            con sede a <strong>{{ $project->ditta_sede }}</strong> - <strong>{{ $project->ditta_partita_iva }}</strong>,
            per complessivi Euro <strong>{{ number_format($project->importo_totale, 2, ',', '.') }}</strong>.=, Iva esclusa, 
            di cui Euro <strong>{{ number_format($project->ditta_oneri_sicurezza, 2, ',', '.') }}</strong>.= oneri di sicurezza,
            alle condizioni indicate nella trattativa n. <strong>{{ $project->ditta_trattativa }}</strong> e nel Foglio Oneri;
        </p>




        <p> Constatato che,</p>

        <ul>
            <li>
                L'affidamento in oggetto relativo all'appalto di <strong>{{ $project->tipo }}</strong>
                    per il periodo contrattuale a far data 
                    <strong>{{ date('d/m/Y', strtotime($project->data_inizio_esecuzione)) }}</strong> - 
                    <strong>{{ date('d/m/Y', strtotime($project->data_fine_esecuzione)) }}</strong>,
                    ha un importo a base d'asta di Euro <strong>{{ number_format($project->importo_totale, 2, ',', '.') }}</strong>, e pertanto la percentuale incentivante è del <strong>{{ $project->percentuale_fondo }}%</strong>;
                
            </li>
            <li>
                    
                    Con la predetta determinazione è stata nominata RUP <strong>{{ $rup }}</strong>
                    e Direttore dell'esecuzione <strong>{{ $dec }}</strong>, 
                    come previsto dall'art.114, comma 8 del D.Lgs n. 36/2023 e dall'art.32, comma 2, Lett. m) dell'allegato II.14,
                    quale servizio di particolare importanza per qualità delle prestazioni;
                                
            </li>
        </ul>
        

        <p class="text-sm"> Visto che l'incentivo previsto per l'affidamento per il periodo contrattuale ammonta a Euro <strong>{{ number_format($project->importo_effettivo_fondo, 2, ',', '.') }}</strong>;</p>
        <p class="text-sm">
            Ritenuto di costituire, a norma dell'art.3 del vigente regolamento sopra richiamato il Gruppo di lavoro,
            individuando il personale che svolgerà le attività tecniche amministrative oggetto di incentivo funzioni tecniche per il predetto periodo contrattuale;
        </p>

        <br /><br />

        <p style="text-align: center"> DISPONE </p>
        <p class="text-sm">
            1. Di costituire il seguente gruppo di lavoro, relativamente al <strong>{{ $project->nome }}</strong>,
            per il periodo dal <strong>{{ date('d/m/Y', strtotime($project->data_inizio_esecuzione)) }}</strong> 
            al <strong>{{ date('d/m/Y', strtotime($project->data_fine_esecuzione)) }}</strong>,
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

        <br><br>

        <p class="text-sm"> Treviso, {{ date('d/m/Y') }} </p>


        <div style="text-align: left">
            <p> 
            Il Dirigente <br>
            {{ $stabiDirigente->nome_diri }}
            </p>
            <p style="font-size: 10px"> Il documento è firmato digitalmente ai sensi del D.Lgs. 82/2005 s.m.i. e norme collegate e sostituisce il documento cartaceo e la firma autografa.</p>
        </div>

    </div>
    {{-- <br> --}}



</page>



{{-- <page>

<h3> <strong> Composizione Gruppo di lavoro </strong> </h3>
        <div class="pt-4">
            
                <table class="morpion" style="width:100%;border:1px solid gray;">
                    
                    <col style="width: 25%; font-size: 10px" class="col1" />
                    <col style="width: 25%" />
                    <col style="width: 25%" />
                    <col style="width: 25%" />

                    <tr>
                        <th style="font-size: 16px; height: 30px">Matricola</th>
                        <th style="font-size: 16px; height: 30px">Cognome</th>
                        <th style="font-size: 16px; height: 30px">Nome</th>
                        <th style="font-size: 16px; height: 30px">Codice Fiscale</th>
                    </tr>

                    @foreach ($employees as $employee)
                        <tr>
                            <td style="font-size: 12px; height: 30px">{{ $employee->matricola }}</td>
                            <td style="font-size: 12px; height: 30px">{{ $employee->cognome }}</td>
                            <td style="font-size: 12px; height: 30px">{{ $employee->nome }}</td>
                            <td style="font-size: 12px; height: 30px">{{ $employee->codice_fiscale }}</td>
                        </tr>
                    @endforeach

                </table>
                <br><br>
        </div>

</page> --}}



{{-- <page>

    <br><br><br><br>


    <div class="pt-16 text-sm">
        <p class="font-bold"> <strong> Settore {{ $project->settore }} </strong> </p>
        <p>Responsabile del Procedimento: {{ $rup }} </p>
        <p>Via cal di Breda, 116 - 31100 Treviso- P.IVA 01138380264 C.F. 80008870265 </p>
        <p>PEC: protocollo.provincia.treviso@pecveneto.it - www.provincia.treviso.it </p>
    </div>


</page> --}}
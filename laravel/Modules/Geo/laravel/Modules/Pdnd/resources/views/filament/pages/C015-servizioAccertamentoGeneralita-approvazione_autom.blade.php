<x-filament-panels::page>
    <x-filament::section>
        <form wire:submit="send">

            {{-- @if(!empty($this->messaggioInfo))
                <div class="mb-6 p-5 bg-amber-100 border border-amber-300 rounded-xl text-amber-700">
                    <strong>⚠️ Attenzione:</strong><br>
                    {{ $this->messaggioInfo }}
                </div>
            @endif --}}

            <x-slot name="heading">
                C015 - Accertamento Generalità
            </x-slot>

            <x-slot name="description">
                Servizio per l'accertamento delle generalità del cittadino tramite ANPR.
                Restituisce i dati anagrafici completi (generalità, stato civile, identificativi, ecc.).
            </x-slot>
            
            {{ $this->pdndForm }}
            
            <br>

            <x-filament::actions :actions="$this->getPdndFormActions()" />

            <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="send()"/>

            <br><br>

            @if($esitoPositivo)
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-success-600 flex items-center gap-2">
                        ✅ Accertamento completato con successo
                    </h3>

                    <!-- LAYOUT A TRE COLONNE CON FLEX (più compatibile) -->
                    <div class="flex flex-col lg:flex-row gap-6">

                    @if(!empty($datiCittadino['generalita']))
                        <x-filament::section heading="Generalità">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div><strong>Cognome:</strong> {{ $datiCittadino['generalita']['cognome'] ?? '-' }}</div>
                                <div><strong>Nome:</strong> {{ $datiCittadino['generalita']['nome'] ?? '-' }}</div>
                                <div><strong>Codice Fiscale:</strong> {{ $datiCittadino['generalita']['codiceFiscale']['codFiscale'] ?? '-' }}</div>

                                @php
                                    $validitaCF = $datiCittadino['generalita']['codiceFiscale']['validitaCF'] ?? null;
                                    $validitaTesto = $validitaCF === '1' ? '✅ Valido' : '❌ Non valido';
                                @endphp
                                <div><strong>Validità CF:</strong> {{ $validitaTesto }}</div>

                                <div><strong>Sesso:</strong> {{ $datiCittadino['generalita']['sesso'] ?? '-' }}</div>
                                <div><strong>Soggetto AIRE:</strong> {{ $datiCittadino['generalita']['soggettoAIRE'] === 'S' ? 'Sì' : 'No' }}</div>

                                @php
                                    $dataNascita = $datiCittadino['generalita']['dataNascita'] ?? null;
                                    $dataFormattata = $dataNascita ? \Carbon\Carbon::parse($dataNascita)->format('d/m/Y') : '-';
                                @endphp
                                <div><strong>Data di nascita:</strong> {{ $dataFormattata }}</div>

                                {{-- LUOGO DI NASCITA MIGLIORATO --}}
                                @php
                                    $luogoNascita = $datiCittadino['generalita']['luogoNascita'] ?? [];
                                    $comune       = $luogoNascita['comune'] ?? [];
                                    $localita     = $luogoNascita['localita'] ?? [];
                                    $luogoEccezionale = $luogoNascita['luogoEccezionale'] ?? null;

                                    if ($comune && !empty($comune['nomeComune'])) {
                                        $luogoFinale = $comune['nomeComune'];
                                        if (!empty($comune['siglaProvinciaIstat'])) {
                                            $luogoFinale .= ' (' . $comune['siglaProvinciaIstat'] . ')';
                                        }
                                    } elseif ($localita && !empty($localita['descrizioneLocalita'])) {
                                        $luogoFinale = $localita['descrizioneLocalita'];
                                        if (!empty($localita['descrizioneStato'])) {
                                            $luogoFinale .= ' (' . $localita['descrizioneStato'] . ')';
                                        }
                                    } elseif ($luogoEccezionale) {
                                        $luogoFinale = $luogoEccezionale;
                                    } else {
                                        $luogoFinale = '-';
                                    }
                                @endphp
                                <div><strong>Luogo di nascita:</strong> {{ $luogoFinale }}</div>
                            </dl>
                        </x-filament::section>
                    @endif


                        <!-- Colonna 3 - Stato Civile -->
                        @if(!empty($datiCittadino['stato_civile']))
                            <x-filament::section heading="Stato Civile" class="flex-1">
                                @php
                                    $codiceStato = $datiCittadino['stato_civile']['statoCivile'] ?? null;
                                    $descrizioni = ['1'=>'Celibe/Nubile','2'=>'Coniugato/a','3'=>'Vedovo/a','4'=>'Divorziato/a','5'=>'Non classificabile','6'=>'Unito civilmente','7'=>'Stato libero (decesso)','8'=>'Stato libero (scioglimento)','9'=>'Non classificabile'];
                                    $descrizione = $descrizioni[$codiceStato] ?? 'Codice sconosciuto';
                                @endphp
                                <p class="text-base font-medium">
                                    {{ $descrizione }} <span class="text-gray-400">({{ $codiceStato }})</span>
                                </p>
                            </x-filament::section>
                        @endif

                    </div>
                </div>
            @else
                <div class="mt-6 p-4 bg-gray-100 rounded-lg text-center">
                    Effettua una ricerca per ottenere i dati richiesti.
                </div>
            @endif

        </form>
    </x-filament::section>
</x-filament-panels::page>
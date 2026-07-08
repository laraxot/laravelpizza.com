<x-filament-panels::page>
    {{-- @if ($this->hasInfolist())
        {{ $this->infolist }}
    @endif --}}

    {{-- @if (count($relationManagers = $this->getRelationManagers()))
        <x-filament-panels::resources.relation-managers
            :active-manager="$this->activeRelationManager"
            :managers="$relationManagers"
            :owner-record="$record"
            :page-class="static::class"
        />
    @endif --}}




    <!-- Main Content Section -->
    <h2 class="text-xl font-semibold text-center mb-4">Fondo incentivante - Liquidazione fase di aggiudicazione incentivi funzioni tecniche</h2>

    <div class="max-w-3xl mx-auto p-6 mt-6 shadow-md rounded-md">
        <p class="mb-4">Constatato che l'intervento in oggetto riguarda appalti di lavori per un valore di <span class="font-bold">1.000.000,00 €</span> per cui la percentuale applicabile per il calcolo del fondo è pari al <span class="font-bold">2%</span>.</p>

        <p class="mb-4">L'incentivo previsto per i lavori in oggetto relativamente alla fase progettuale e alla fase di esecuzione e collaudo, ammonta a complessivi <span class="font-bold">20.000,00 €</span> da cui vengono dedotte la quota del <span class="font-bold">20%</span> per il fondo per l'innovazione pari a <span class="font-bold">4.000,00 €</span> e le quote per incarichi professionali esterni.</p>

        <p class="mb-4">Sentito il RUP del procedimento in oggetto, la somma liquidabile da ripartire internamente risulta pari a <span class="font-bold">16.000,00 €</span>.</p>

        <p class="mb-4">Attuate le corrette correzioni al gruppo di lavoro ed al lavoro eseguito dovute dalla dinamicità del progetto.</p>

        <!-- Table Section -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-2">IPOTESI LAVORI CALCOLO FONDO INCENTIVANTE LAVORI</h3>
            <table class="w-full text-left table-auto border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-200 px-4 py-2">DESCRIZIONE</th>
                        <th class="border border-gray-200 px-4 py-2">% IMPORTO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-200 px-4 py-2">Importo dei lavori a base d'asta (art.5 comma 2)</td>
                        <td class="border border-gray-200 px-4 py-2">1.000.000,00 €</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-4 py-2">Percentuale effettiva del fondo in base all'importo (art.5 comma 1)</td>
                        <td class="border border-gray-200 px-4 py-2">2,00% 20.000,00 €</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-4 py-2">Fondo per l'innovazione</td>
                        <td class="border border-gray-200 px-4 py-2">20% 4.000,00 €</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-4 py-2">Componente Incentivante (art.4 comma 2)</td>
                        <td class="border border-gray-200 px-4 py-2">80% 16.000,00 €</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Detailed Activities Section -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-2">Macroattività</h3>
            <table class="w-full text-left table-auto border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-200 px-4 py-2">Attività</th>
                        <th class="border border-gray-200 px-4 py-2">% Importo</th>
                        <th class="border border-gray-200 px-4 py-2">Anno di Competenza</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-200 px-4 py-2">R.U.P.</td>
                        <td class="border border-gray-200 px-4 py-2">24% 3.840,00 €</td>
                        <td class="border border-gray-200 px-4 py-2">2022</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-4 py-2">Programmazione della spesa per investimenti</td>
                        <td class="border border-gray-200 px-4 py-2">2% 320,00 €</td>
                        <td class="border border-gray-200 px-4 py-2">2023</td>
                    </tr>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-4 py-2 font-bold">Totale</td>
                        <td class="border border-gray-200 px-4 py-2 font-bold">100% 16.000,00 €</td>
                        <td class="border border-gray-200 px-4 py-2"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer Section -->
        <footer class="mt-8 text-center text-sm">
            <p>Il Dirigente del Settore Edilizia, Patrimonio e S.A.<br>Dott. Ing. Marina Coghetto</p>
        </footer>
    </div>







</x-filament-panels::page>

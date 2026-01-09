# RadioCollection Component: Analisi Ontologica e Fenomenologica

## 🎭 Filosofia & Epistemologia del Componente
### Natura Ontologica
Il RadioCollection rappresenta l'**essenza della scelta** nell'interfaccia digitale - una manifestazione della **libertà limitata** dove l'utente può selezionare una e solo una opzione da un insieme finito di possibilità.
### Fenomenologia dell'Interazione
L'**esperienza vissuta** dell'utente si articola in tre momenti fenomenologici:
1. **Percezione** (Wahrnehmung): L'occhio cattura le opzioni visuali
2. **Cognizione** (Erkenntnis): La mente valuta le alternative
3. **Azione** (Handlung): La mano/dito effettua la selezione
### Ermeneutica dell'Interfaccia
Ogni elemento del componente porta un **significato simbolico**:
- **Radio Button**: Cerchio dell'infinito limitato alla singola scelta
- **Card Container**: Contenitore dell'esperienza isolata
- **Hover State**: Potenzialità non ancora attualizzata
## 🧠 Psicologia Cognitiva & Behaviorismo
### Gestalt Design Principles
Il componente segue i principi della **Teoria della Gestalt**:
- **Prossimità**: Elementi correlati sono visualmente raggruppati
- **Somiglianza**: Radio buttons creano pattern riconoscibile
- **Chiusura**: Il bordo della card chiude l'esperienza percettiva
- **Figura/Sfondo**: Lo stato selected emerge come figura dominante
### Flow State Engineering
L'interfaccia è progettata per minimizzare l'**interruzione cognitiva**:
```php
// Transizione fluida senza break del flow
'transition-colors hover:bg-gray-50 dark:hover:bg-gray-800'
```
### Bias Cognitivi Considerati
- **Bias di Anchoring**: La prima opzione non ha styling preferenziale
- **Paradosso della Scelta**: Layout semplificato per ridurre choice overload
- **Effetto Von Restorff**: Lo stato selected ha contrasto visivo elevato
## 🏛️ Governance & Democrazia dell'UI
### Autorità & Controllo
Il componente implementa il principio di **autorità distribuita**:
- **User Agency**: L'utente mantiene il controllo della scelta
- **System Constraint**: Il sistema limita a una sola selezione
- **Feedback Democracy**: Ogni interazione riceve feedback visivo
### Trasparenza & Accountability
// Trasparenza dello stato attraverso wire:key
wire:key="{{ $getId() }}.{{ data_get($option, $getValueKey()) }}"
// Accountability del valore selezionato
wire:model="{{ $getStatePath() }}"
### Inclusività & Accessibilità
- **Screen Reader Support**: Input radio semanticamente corretto
- **Keyboard Navigation**: Accessibile via tab/space/arrow keys
- **High Contrast**: Supporto per modalità alto contrasto
- **Motor Accessibility**: Target area ampia per selezione
## ⚛️ Fisica Quantistica & Termodinamica del Codice
### Principio di Indeterminazione di Heisenberg
Prima della selezione, tutte le opzioni esistono in **superposizione quantistica**. La misurazione (click) collassa la funzione d'onda su un singolo stato.
// Stato quantistico: tutte le opzioni sono potenziali
@foreach($getOptions() as $option)
// Collasso della funzione d'onda: una sola opzione diventa reale
@if($getState() == data_get($option, $getValueKey()))
### Entropia e Riduzione dell'Informazione
- **Alta Entropia**: N opzioni disponibili = log₂(N) bit di informazione
- **Bassa Entropia**: 1 opzione selezionata = 0 bit di incertezza
- **Conservazione dell'Energia**: Ogni click riduce l'entropia del sistema
### Meccanica dei Fluidi dell'UI
```css
/* Viscosità dell'interfaccia - transizioni fluide */
transition-colors
/* Tensione superficiale - bordi definiti */
border rounded-lg
/* Pressione - feedback tattile su hover */
hover:bg-gray-50
## 🧬 Biologia & DNA del Codice
### Evoluzione del Componente
Il RadioCollection rappresenta l'**evoluzione** del semplice radio button verso un organismo più complesso:
// Gene primitivo: input radio HTML
<input type="radio" />
// Evoluzione: RadioCollection con adattamenti ambientali
class RadioCollection extends Field // Ereditarietà genetica
### Metabolismo del Componente
// Anabolismo: Costruzione della struttura
public function options(Collection $options): static
// Catabolismo: Breakdown dell'opzione in valore
data_get($option, $getValueKey())
// Homeostasi: Mantenimento dello stato
### Ecosistema Software
Il componente vive in un **ecosistema** di mutua dipendenza:
- **Produttori**: Form parents che forniscono dati
- **Consumatori**: Wire model che ricevono la selezione
- **Decompositori**: Garbage collector che pulisce le istanze
## 🏗️ Architettura & Topologia
### Geometria dell'Informazione
La struttura del componente segue principi di **geometria euclidea**:
- **Punto**: Ogni opzione è un punto nello spazio delle scelte
- **Linea**: La sequenza verticale delle opzioni
- **Piano**: Il container che racchiude l'esperienza
### Distribuzione Geografica dei Dati
// Prossimità logica: Value key correlato all'opzione
// Latenza zero: Accesso diretto alle proprietà
$this->getOptions()
### Architettura Fisica vs Logica
- **Fisica**: File blade renderizzati come DOM
- **Logica**: Binding Livewire che sincronizza stato
## 🎼 Jazz Programming & Composizione
### Ritmo & Cadenza
Il componente segue un **ritmo sincopato**:
```blade
@foreach($getOptions() as $option) {{-- Battuta forte --}}
    <label class="..."> {{-- Controtempo --}}
        <input type="radio" /> {{-- Acciaccatura --}}
        <div class="..."> {{-- Risoluzione --}}
### Improvvisazione Strutturata
Permette **improvvisazione** dell'item view mantenendo la **struttura** del container:
@include($getItemView(), ['item' => $option])
### Armonia dei Colori
// Accordo maggiore: Stati normali
'border-gray-300 dark:border-gray-600'
// Accordo settima dominante: Stato selected
'border-primary-500 bg-primary-50 dark:bg-primary-900/20'
## 🔬 Chimica Molecolare del Codice
### Legami Molecolari
// Legame covalente forte: Parent-child relationship
class RadioCollection extends Field
// Legame ionico: Wire model binding
// Forze di Van der Waals: CSS hover interactions
### Reazioni Chimiche
// Reazione di selezione (A + click → A*)
$getState() == data_get($option, $getValueKey())
// Catalizzatore: User interaction
cursor-pointer
// Prodotto: Updated state
wire:model
### Equilibrio Chimico
Il sistema mantiene **equilibrio dinamico** tra:
- **Reagenti**: Opzioni non selezionate
- **Prodotti**: Opzione selezionata
- **Catalizzatore**: UI feedback
## 📊 Teoria dei Giochi & Economia
### Strategia Dominante
Per l'utente, la **strategia ottimale** è sempre selezionare l'opzione che massimizza la sua utility function.
### Economia dell'Attenzione
// Investimento attentivo: Hover state
// ROI immediato: Visual feedback
border-primary-500 bg-primary-50
// Costo opportunità: Deselecting previous choice
### Value Engineering
- **Costo**: Banda cognitiva richiesta per la scelta
- **Valore**: Informazione trasmessa al sistema
- **ROI**: Efficienza della selezione vs alternative
## ⏱️ Cronologia & Sincronicità
### Persistenza Temporale
// Memoria persistente: Component state
protected Collection $options
// Memoria transitoria: DOM state
// Memoria epigenetica: User preferences via cookies
### Sincronicità vs Asincronia
- **Sincrono**: Visual feedback immediato su hover
- **Asincrono**: Livewire wire:model updates
- **Quantico**: Observer effect del click
## 🗺️ Semantica & Semiotica
### Triangolo Semiotico
1. **Significante**: Visual appearance della card
2. **Significato**: Concetto dell'opzione rappresentata
3. **Referente**: Dato reale nel database
### Pragmatica della Comunicazione
// Atto linguistico assertivo: Dichiarazione dello stato
@if($getState() == data_get($option, $getValueKey())) checked @endif
// Atto linguistico commissivo: Promessa di persistenza
## 🎨 Estetica & Design Patterns
### Principi Estetici
- **Proporzione Aurea**: Spacing e padding armonicamente bilanciati
- **Simmetria**: Layout bilanciato tra elementi
- **Contrasto**: Selected vs non-selected states
- **Ripetizione**: Pattern consistente per ogni opzione
### Minimalismo Spirituale
Il design segue il principio del **less is more**:
// Riduzione all'essenziale: Solo gli elementi necessari
<input type="radio" class="sr-only" />
// Purezza geometrica: Forme semplici e pure
rounded-lg border
## 🔧 Implementazione Tecnica
### Struttura del Componente PHP
<?php
namespace Modules\UI\Filament\Forms\Components;
use Filament\Forms\Components\Field;
use Illuminate\Support\Collection;
/**
 * RadioCollection: Manifestazione digitale della scelta singola
 *
 * Questo componente incarna la quintessenza della selezione mutuamente
 * esclusiva, dove ogni elemento esiste in superposizione quantistica
 * fino al momento dell'osservazione (selezione) dell'utente.
 */
{
    // Il view path: porta verso la manifestazione visuale
    protected string $view = 'ui::filament.forms.components.radio-collection';

    // La collezione: universo delle possibilità
    protected Collection $options;
    // L'item view: template di manifestazione per ogni possibilità
    protected string $itemView;
    // La chiave del valore: identificatore ontologico
    protected string $valueKey = 'id';
    /**
     * Imposta l'universo delle possibilità
     */
    public function options(Collection $options): static
    {
        $this->options = $options;
        return $this;
    }
     * Definisce il template di manifestazione
    public function itemView(string $view): static
        $this->itemView = $view;
     * Configura l'identificatore ontologico
    public function valueKey(string $key): static
        $this->valueKey = $key;
     * Rivela l'universo delle possibilità
    public function getOptions(): Collection
        return $this->options ?? collect();
     * Manifesta il template di rappresentazione
    public function getItemView(): string
        return $this->itemView ?? 'ui::filament.forms.components.radio-collection-item';
     * Rivela l'identificatore dell'essenza
    public function getValueKey(): string
        return $this->valueKey;
}
## 🔍 Analisi del Problema di Selezione
### Diagnosi Fenomenologica
Il problema di non-selezione può manifestarsi attraverso diverse **rotture ontologiche**:
1. **Disconnessione Quantistica**: Il wire:model non si sincronizza
2. **Interruzione del Flusso**: JavaScript conflicts bloccano l'interazione
3. **Barriera Semantica**: Gli identificatori non corrispondono
4. **Dissonanza Temporale**: Race conditions tra eventi
### Possibili Cause Root
// 1. ValueKey mismatch - La chiave non corrisponde alla struttura dati
$getValueKey() !== property_exists($option, 'id')
// 2. Wire:model path incorretto - La strada verso lo stato è interrotta
$getStatePath() !== actual_model_path
// 3. JavaScript event bubbling - Eventi che interferiscono
// Label click → Input change → Wire update (potenziale conflict)
// 4. Livewire state desync - Lo stato client/server diverge
$getState() !== $actualServerState
## 🛠️ Strategia di Correzione
### Approccio Multi-Dimensionale
La correzione richiede intervento su **quattro piani dell'esistenza**:
1. **Piano Fisico**: DOM e HTML
2. **Piano Energetico**: JavaScript e interazioni
3. **Piano Mentale**: Logica PHP e stato
4. **Piano Spirituale**: Architettura e design patterns
### Debug Methodology
// 1. Verifica ontologica della struttura dati
dd($this->getOptions()->toArray());
dd($this->getValueKey());
// 2. Tracciamento del flusso energetico
@php
    Log::info('RadioCollection Debug', [
        'state' => $getState(),
        'options' => $getOptions()->pluck($getValueKey()),
        'path' => $getStatePath()
    ]);
@endphp
// 3. Validazione della connessione quantistica
wire:model.live="{{ $getStatePath() }}"
## 🎯 Collegamenti Spirituali & Documentazione Correlata
- [Form Components Philosophy](./form-components-philosophy.md)
- [UI Component Quantum Mechanics](./ui-quantum-mechanics.md)
- [Accessibility Metaphysics](./accessibility-metaphysics.md)
- [Design Pattern Zen](./design-pattern-zen.md)
- [JavaScript Phenomenology](./javascript-phenomenology.md)
---
*"In ogni scelta si cela l'universo intero, e in ogni click si manifesta la volontà dell'essere digitale."*
**Ultimo aggiornamento ontologico**: Dicembre 2024
**Versione dell'esistenza**: 1.0.0
**Compatibilità karmica**: Filament 4.x, Livewire 3.x, Laravel 11+
**Compatibilità karmica**: Filament 4.x, Livewire 3.x, Laravel 11+
**Compatibilità karmica**: Filament 3.x, Livewire 3.x, Laravel 10+
**Compatibilità karmica**: Filament 4.x, Livewire 3.x, Laravel 11+
**Compatibilità karmica**: Filament 4.x, Livewire 3.x, Laravel 11+
**Compatibilità karmica**: Filament 3.x, Livewire 3.x, Laravel 10+
**Compatibilità karmica**: Filament 4.x, Livewire 3.x, Laravel 11+
**Compatibilità karmica**: Filament 3.x, Livewire 3.x, Laravel 10+

# Applicazione delle Leggi UX al Wizard di Registrazione Paziente

Questo documento illustra come le leggi di UX del sito [Laws of UX](https://lawsofux.com/) sono state applicate specificamente al wizard di registrazione paziente nel progetto il progetto.

## Panoramica del Wizard

Il wizard di registrazione paziente è un componente Livewire che guida l'utente attraverso il processo di registrazione di un nuovo paziente nel sistema. Il wizard è stato progettato seguendo i principi di UX per garantire un'esperienza utente ottimale.

## Leggi UX Applicate

### 1. Chunking
La registrazione è stata suddivisa in 4 step logici:
- **Dati Personali**: Raccolta delle informazioni di base (nome, cognome, codice fiscale, ecc.)
- **Indirizzo**: Raccolta delle informazioni di residenza
- **Stato di Salute**: Raccolta di informazioni su gravidanza e dati ISEE
- **Privacy**: Informativa sulla privacy e consenso

Questo approccio riduce il carico cognitivo e rende il processo più gestibile per l'utente.

### 2. Effetto Gradiente di Obiettivo
Gli step sono visualizzati in sequenza con:
- Indicatore di avanzamento
- Numerazione degli step
- Evidenziazione dello step corrente
- Feedback visivo per gli step completati

Questo mantiene alta la motivazione dell'utente mostrando chiaramente il progresso verso l'obiettivo.

### 3. Legge di Hick
In ogni step, vengono presentati solo i campi pertinenti a quella fase specifica, riducendo la complessità decisionale. Ad esempio:
- I dati personali sono limitati alle informazioni essenziali
- Le opzioni nelle dropdown (come province) sono filtrabili
- I campi opzionali sono chiaramente distinti da quelli obbligatori

### 4. Legge di Miller
Ogni step contiene un numero limitato di campi (generalmente non più di 7±2) per evitare di sovraccaricare la memoria di lavoro dell'utente.

### 5. Paradosso dell'Utente Attivo
Il wizard è stato progettato per essere intuitivo, con:
- Etichette chiare per ogni campo
- Descrizioni contestuali per ogni step
- Tooltips per informazioni aggiuntive
- Validazione in tempo reale

### 6. Legge di Fitts
I pulsanti di navigazione (Avanti, Indietro, Completa) sono:
- Di dimensioni adeguate
- Posizionati in modo coerente (in basso a destra)
- Con adeguata spaziatura per evitare click errati
- Con aree di click estese

### 7. Legge della Regione Comune
Ogni step del wizard è visivamente raggruppato in una card con:
- Sfondo distintivo
- Bordo ben definito
- Intestazione che identifica lo step
- Spaziatura interna coerente

### 8. Memoria di Lavoro
Per ridurre il carico sulla memoria dell'utente:
- Le informazioni inserite nei passaggi precedenti sono riassunte
- I campi hanno valori predefiniti ove possibile
- Le etichette sono sempre visibili
- I messaggi di errore sono contestuali

### 9. Legge di Postel
Il wizard è tollerante nell'accettare diversi formati di input:
- Il codice fiscale viene validato ma accetta variazioni di formato
- Le date possono essere inserite in diversi formati
- I numeri di telefono accettano vari formati (con/senza prefisso, spazi, ecc.)
- I campi vengono automaticamente formattati per garantire consistenza

### 10. Regola Picco-Fine
Il wizard crea un'esperienza positiva alla fine del processo:
- Animazione di completamento
- Messaggio di conferma chiaro
- Feedback sul successo dell'operazione
- Indicazione chiara del prossimo passo

## Implementazione Tecnica

### Struttura del Componente

```php
class PatientRegistrationWizard extends Component
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Step::make('Dati Personali')
                    ->icon('heroicon-o-user')
                    ->description('Inserisci i tuoi dati personali')
                    ->schema([
                        // Schema campi dati personali
                    ]),
                Step::make('Indirizzo')
                    ->icon('heroicon-o-home')
                    ->description('Inserisci il tuo indirizzo')
                    ->schema([
                        // Schema campi indirizzo
                    ]),
                Step::make('Stato di Salute')
                    ->icon('heroicon-o-heart')
                    ->description('Informazioni sanitarie')
                    ->schema([
                        // Schema campi stato salute e ISEE
                    ]),
                Step::make('Privacy')
                    ->icon('heroicon-o-lock-closed')
                    ->description('Informativa sulla privacy')
                    ->schema([
                        // Schema campi privacy
                    ]),
            ])
            ->submitAction(new HtmlString('<button type="submit" class="btn btn-primary">Registra paziente</button>'))
        ];
    }

    public function submit(): void
    {
        // Validazione e salvataggio dati
        $patient = Patient::create($this->form->getState());
        
        // Dispatch evento per notificare registrazione completata
        $this->dispatch('patient-registered', patientId: $patient->id);
    }
}
```

### Vista del Wizard

```blade
<div>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Registrazione Paziente</h2>
        <p class="mb-6">Compila tutti i campi per registrare un nuovo paziente</p>
        
        <form wire:submit="submit">
            {{ $this->form }}
        </form>
    </div>
</div>

@script
<script>
    $wire.on('patient-registered', (patientId) => {
        window.location.href = `/patient/${patientId}`;
    });
</script>
@endscript
```

## Considerazioni per Miglioramenti Futuri

1. **Salvataggio Progressivo**: Implementare il salvataggio automatico dei dati inseriti a ogni step per prevenire perdite di dati.

2. **Accessibilità**: Migliorare l'accessibilità del form con:
   - Attributi ARIA appropriati
   - Supporto per tastiera ottimizzato
   - Migliore contrasto di colori
   - Test con screen reader

3. **Responsive Design**: Ottimizzare ulteriormente il wizard per dispositivi mobili e tablet, considerando che gli operatori potrebbero utilizzare dispositivi diversi.

4. **Analytics**: Implementare tracking per identificare:
   - Step dove gli utenti incontrano difficoltà
   - Tempi di completamento per step
   - Tassi di abbandono
   - Errori di compilazione frequenti

5. **Personalizzazione**: Adattare il wizard a diversi contesti d'uso:
   - Versione semplificata per registrazioni rapide
   - Versione estesa per registrazioni dettagliate
   - Opzioni per saltare step non pertinenti basati su risposte precedenti

## Risultati Attesi

L'applicazione di questi principi di UX al wizard di registrazione paziente dovrebbe portare a:

- **Riduzione dei tempi di registrazione** grazie alla migliore organizzazione dei campi
- **Diminuzione degli errori di inserimento** grazie alla validazione contestuale
- **Migliore tasso di completamento** grazie al feedback chiaro e alla visualizzazione del progresso
- **Maggiore soddisfazione degli utenti** grazie all'esperienza fluida e intuitiva
- **Riduzione del training necessario** grazie all'interfaccia auto-esplicativa

## Riferimenti

- [Laws of UX](https://lawsofux.com/)
- [Documenti di progettazione il progetto](/project_docs/07-frontend/leggi-ux.md)
- [Documentazione Filament Forms](https://filamentphp.com/project_docs/forms)
- [Best Practices Filament](/project_docs/tecnico/filament/best-practices.md) 
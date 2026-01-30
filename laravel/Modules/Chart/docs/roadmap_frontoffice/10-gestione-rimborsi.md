# Implementazione Gestione Rimborsi

## Panoramica
Questo documento descrive l'implementazione del sistema di gestione rimborsi per gli odontoiatri nel portale <nome progetto>, includendo la compilazione dei referti post-visita, la generazione automatica delle richieste di rimborso e il monitoraggio dello stato.

## Componenti Principali

### 1. Form Referto Visita (85% completato)
- Compilazione strutturata del referto post-visita
- Selezione delle prestazioni eseguite da catalogo
- Upload di eventuali documenti diagnostici
- **TODO**: Ottimizzare la gestione di prestazioni multiple

### 2. Generazione Richiesta Rimborso (90% completato)
- Creazione automatica della richiesta dopo compilazione referto
- Calcolo automatico degli importi in base alle prestazioni
- Verifica dei requisiti di completezza
- **TODO**: Migliorare la generazione del PDF riepilogativo

### 3. Dashboard Rimborsi (75% completato)
- Visualizzazione stato di tutte le richieste
- Filtri per stato (in attesa, approvata, pagata)
- Cronologia completa con log delle modifiche
- **TODO**: Implementare sistema di notifiche per cambi di stato

### 4. Emissione Fattura (80% completato)
- Workflow guidato per emissione fattura
- Template precompilati con dati corretti
- Verifica di coerenza con la richiesta di rimborso
- **TODO**: Migliorare integrazione con software gestionali

## Implementazione Tecnica

### Livewire Components
La dashboard rimborsi è implementata con componenti Livewire per una gestione reattiva:

```php
class ReimbursementDashboard extends Component
{
    public function render()
    {
        return view('livewire.reimbursement-dashboard', [
            'reimbursements' => $this->getReimbursements(),
        ]);
    }
    
    // Altri metodi
}
```

### Filament Forms
I form per la compilazione dei referti utilizzano Filament per una migliore esperienza utente:

```php
public function getFormSchema(): array
{
    return [
        'visit_date' => Forms\Components\DatePicker::make('visit_date')
            ->required(),
        'treatments' => Forms\Components\Repeater::make('treatments')
            ->schema([
                'type' => Forms\Components\Select::make('type')
                    ->options($this->getTreatmentOptions())
                    ->required(),
                'notes' => Forms\Components\Textarea::make('notes'),
            ]),
        // Altri campi
    ];
}
```

### Integrazione Backoffice
Il sistema si integra con il backoffice per la gestione dei rimborsi:

```php
class ReimbursementService
{
    public function createReimbursementRequest(Visit $visit): Reimbursement
    {
        // Logica per creare la richiesta di rimborso
    }
    
    public function updateReimbursementStatus(Reimbursement $reimbursement, string $status): void
    {
        // Logica per aggiornare lo stato
    }
}
```

## Ottimizzazioni Future

### UX/UI (70% completato)
- Migliorare la presentazione dello stato dei rimborsi
- Ottimizzare la visualizzazione su dispositivi mobili
- Implementare notifiche push per aggiornamenti

### Integrazione (65% completato)
- Connessione con software gestionali per fatturazione
- Esportazione dati in formati standard
- Integrazione con sistemi di pagamento elettronico

### Reporting (50% completato)
- Generazione report mensili/trimestrali
- Statistiche sui tempi di rimborso
- Analisi delle prestazioni più frequenti

## Metriche di Successo
- Tempo medio di gestione referto < 5 minuti
- Tempo di approvazione rimborsi < 7 giorni
- Errori di compilazione < 3%
- Soddisfazione degli odontoiatri > 4.5/5

## Collegamenti
- [← Torna alla Roadmap Frontoffice](/var/www/html/<nome progetto>/docs/roadmap_frontoffice.md)
- [Dashboard Odontoiatra](/var/www/html/<nome progetto>/docs/roadmap_frontoffice/08-dashboard-odontoiatra.md)
- [Iscrizione Odontoiatra](/var/www/html/<nome progetto>/docs/roadmap_frontoffice/09-iscrizione-odontoiatra.md)

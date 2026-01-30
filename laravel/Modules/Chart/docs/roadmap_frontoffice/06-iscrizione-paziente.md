# Implementazione Iscrizione Paziente

## Panoramica
Questo documento descrive l'implementazione dettagliata del processo di iscrizione delle pazienti al portale <nome progetto>, includendo raccolta dati anagrafici, caricamento documentazione, questionario anamnestico e privacy.

## Componenti Principali

### 1. Form Dati Anagrafici (90% completato)
- Raccolta completa dei dati personali
- Validazione dei campi in tempo reale
- Salvataggio progressivo del form
- **TODO**: Ottimizzare la gestione degli errori di input

### 2. Upload Documentazione (80% completato)
- Caricamento tessera sanitaria/STP/ENI
- Upload autocertificazione ISEE
- Documentazione attestante gravidanza
- **TODO**: Implementare anteprima dei documenti caricati
- **TODO**: Migliorare feedback durante l'upload

### 3. Questionario Anamnestico (85% completato)
- Form multistep con salvataggio progressivo
- Domande personalizzate in base alle risposte precedenti
- Logica condizionale per mostrare campi pertinenti
- **TODO**: Aggiungere indicatori di progresso più chiari

### 4. Gestione Privacy (100% completato)
- Modulo di consenso al trattamento dei dati
- Opzioni per comunicazioni e notifiche
- Download della documentazione privacy
- Tracciamento del consenso con timestamp

### 5. Schermata Completamento (75% completato)
- Conferma di registrazione avvenuta
- Indicazioni sui prossimi passi
- Istruzioni per il processo di verifica
- **TODO**: Implementare sistema di notifiche per approvazione

## Implementazione Tecnica

### Livewire Forms
I form complessi sono implementati con Livewire per gestire la validazione e il salvataggio progressivo:

```php
class RegistrationForm extends Component implements HasForms
{
    use InteractsWithForms;
    
    // Implementazione del form
}
```

### Filament Forms (integrazione Volt)
```php
@volt
<?php
    public function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required(),
            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->required(),
            // Altri campi
        ];
    }
@endvolt
```

### Gestione Upload
Per la gestione dei documenti viene utilizzato Livewire File Upload con validazioni specifiche:

```php
public array $documents = [];

protected function rules()
{
    return [
        'documents.*' => 'file|mimes:pdf,jpg,png|max:10240',
    ];
}
```

## Ottimizzazioni Future

### UX/UI (65% completato)
- Migliorare il sistema di feedback durante la registrazione
- Ottimizzare l'esperienza su dispositivi mobili
- Implementare autosalvataggio più granulare

### Sicurezza (80% completato)
- Migliorare la crittografia dei dati sensibili
- Implementare ulteriori controlli anti-frode
- Ottimizzare la gestione delle sessioni

### Performance (70% completato)
- Ottimizzare il caricamento dei documenti
- Migliorare la validazione asincrona
- Ridurre il tempo di risposta del server

## Metriche di Successo
- Tasso di completamento registrazione > 70%
- Tempo medio per completare il processo < 10 minuti
- Tasso di errore nei form < 5%
- Tasso di approvazione documenti > 90%

## Collegamenti
- [← Torna alla Roadmap Frontoffice](/var/www/html/<nome progetto>/docs/roadmap_frontoffice.md)
- [Homepage e Landing](/var/www/html/<nome progetto>/docs/roadmap_frontoffice/05-homepage-landing.md)
- [Prenotazione Visite](/var/www/html/<nome progetto>/docs/roadmap_frontoffice/07-prenotazione-visite.md)

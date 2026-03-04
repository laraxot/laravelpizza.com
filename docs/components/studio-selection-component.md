# Studio Selection Component con Pulsanti

## Descrizione
Componente Filament riutilizzabile per la visualizzazione e selezione di studi odontoiatrici tramite pulsanti interattivi. Progettato per il secondo step del wizard `FindDoctorAndAppointmentWidget`, questo componente consente una selezione visuale degli studi dentistici attraverso card cliccabili, migliorando l'esperienza utente rispetto ai tradizionali campi select.

## Funzionamento

- Visualizza studi dentistici come una serie di card cliccabili
- Ogni card contiene informazioni essenziali: nome studio, indirizzo, telefono, ecc.
- Quando una card viene cliccata, popola un campo hidden con l'ID dello studio
- Il pulsante "Prenota" conferma la selezione
- L'interfaccia evidenzia visivamente la scelta attuale

## Utilizzo nel Wizard

```php
use Modules\UI\Filament\Forms\Components\StudioSelectorButtons;

protected function getStudioStepSchema(): array
{
    return [
        StudioSelectorButtons::make('studio_id')
            ->filteredBy([
                'region' => $this->getState()['region'] ?? null,
                'province' => $this->getState()['province'] ?? null,
                'cap' => $this->getState()['cap'] ?? null,
            ])
            ->required()
            ->columnSpanFull()
    ];
}
```

## Vantaggi rispetto ai select tradizionali

- Interfaccia più intuitiva ed user-friendly
- Visualizzazione immediata delle informazioni importanti
- Allineamento con le moderne pratiche di UX
- Maggiore accessibilità e usabilità su dispositivi mobili
- Possibilità di arricchire visivamente l'interfaccia (immagini, icone, ecc.)

## Layout Responsive

- **Mobile**: Layout a singola colonna con card impilate verticalmente
- **Desktop**: Layout a due colonne con mappa interattiva (opzionale)
- Adattamento automatico alle dimensioni del viewport
- Ottimizzazione per dispositivi touch e desktop

## Implementazione

Il componente è costruito secondo le best practice Filament:

- Estende la classe base `Component` di Filament
- Utilizza un campo nascosto per memorizzare il valore selezionato
- Reagisce e trasmette eventi standard di Filament
- Implementa validazione e stato di errore
- Supporta temi chiari e scuri

## UI/UX

- Feedback visivo immediato alla selezione (evidenziazione, bordo colorato)
- Animazioni ed effetti hover per migliorare l'interazione
- Icone contestuali per indirizzo, telefono e altre informazioni
- Design coerente con le linee guida dell'applicazione

## Accessibilità

- Supporto completo per navigazione da tastiera
- Markup semantico per screen reader
- Contrasto colori adeguato
- Testi alternativi per tutti gli elementi visivi

## Personalizzazione

Il componente può essere personalizzato in vari modi:

- Filtri geografici
- Layout e stili tramite classi CSS
- Informazioni da visualizzare
- Comportamento di selezione e interazione

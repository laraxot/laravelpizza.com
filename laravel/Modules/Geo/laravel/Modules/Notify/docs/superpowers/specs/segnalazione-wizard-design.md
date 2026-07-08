# Design: Ticket Wizard Widget (Filament)

## Obiettivo

Unificare le 4 pagine di creazione ticket in un singolo Filament Wizard Widget:
- `segnalazione-01-privacy` → Step 1: Auth/Privacy (gia presente)
- `segnalazione-02-dati` → Step 2: Data (gia presente)
- `segnalazione-03-riepilogo` → Step 3: Summary (da aggiungere)
- `segnalazione-04-conferma` → Step 4: Confirmation (da aggiungere)

## Paradigma

- **Widget-based**: Il widget viene inserito nella pagina CMS come blocco
- **Forward-only**: Filament gestisce stato e navigazione tra step
- **Esistente**: Estendere `CreateTicketWidget` esistente

## Struttura

### File da modificare/creare

1. **`laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWidget.php`**
   - Aggiungere Step 3 (Riepilogo) e Step 4 (Conferma)
   - Aggiornare `getFormSchema()` con 4 step

2. **`laravel/config/local/fixcity/database/content/pages/tests.ticket-create.json`**
   - Nuovo file JSON per la pagina
   - Definisce i blocchi della pagina

3. **`laravel/Themes/Sixteen/resources/views/components/blocks/tests/ticket-create.blade.php`**
   - Nuovo componente Blade per il blocco CMS

### Traduzioni

Pattern: `fixcity::ticket.steps.<item>.<tipo>`

```json
{
    "steps": {
        "privacy": { "label": "Privacy", "description": "..." },
        "data": { "label": "Dati", "description": "..." },
        "summary": { "label": "Riepilogo", "description": "..." },
        "confirmation": { "label": "Conferma", "description": "..." }
    }
}
```

## Step Details

### Step 1: Privacy (gia implementato)
- RichEditor: Privacy notice (readonly)
- Checkbox: Accetta termini (required)

### Step 2: Dati (gia implementato)
- Titolo, descrizione, tipo disservizio
- Luogo (mappa/indirizzo)
- Allegati (foto)
- Contatti (email, telefono)

### Step 3: Riepilogo (DA IMPLEMENTARE)
- Mostra tutti i dati inseriti
- Edit button per tornare a step specifici
- Submit per invio

### Step 4: Conferma (DA IMPLEMENTARE)
- Messaggio di successo
- Numero protocollo
- Link a segnalazioni utente
- Link a "Nuova segnalazione"

## Integrazione CMS

Il widget viene esposto come blocco CMS:
- **Tipo**: `filament-widget`
- **Widget**: `Modules\Fixcity\Filament\Widgets\CreateTicketWidget`
- **Posizionamento**: Main content area

## Note

- Le 4 pagine vecchie rimangono (backward compatibility)
- Il widget usa la stessa logica di salvataggio esistente
- Le traduzioni estendono il pattern esistente

## TODO

1. Estendere `CreateTicketWidget` con Step 3-4
2. Creare file JSON per pagina `segnalazione-crea`
3. Creare componente Blade per il blocco
4. Aggiungere traduzioni mancanti
5. Testare il wizard completo
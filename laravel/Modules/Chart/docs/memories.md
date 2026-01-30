- Ricorda: spatie/laravel-model-states è potente per stati semplici, ma non sostituisce un workflow engine o un modello workflow custom.
- Se serve storicizzazione, dati intermedi, ruoli, step asincroni, preferire un modello workflow. 

## Errori da Non Ripetere

1. **Gerarchia delle Classi User**
   - ❌ NON assumere che User estenda Model o BaseModel
   - ✅ Verificare SEMPRE la gerarchia completa:
     ```
     BaseUser (Modules\User\Models\BaseUser)
     ↓
     User (Modules\Patient\Models\User)
     ↓
     Doctor (Modules\Patient\Models\Doctor)
     ```
   - ✅ Documentare la gerarchia in ogni file di dettaglio
   - ✅ Mantenere aggiornata la documentazione quando la gerarchia cambia 

2. **Mutators e Casts**
   - ❌ NON usare più `protected $casts = []`
   - ✅ Usare SEMPRE il metodo `casts()` in Laravel 12
   - ✅ Implementare mutators custom quando necessario
   - ✅ Documentare i tipi di cast utilizzati

3. **Wizard di Registrazione**
   - ❌ NON permettere il completamento in un'unica sessione
   - ✅ Implementare un processo a step con verifica email
   - ✅ Generare e tracciare token di completamento
   - ✅ Inviare email di continuazione solo dopo moderazione

4. **Gestione Giorni della Settimana**
   - ❌ NON usare array hardcoded per i giorni
   - ❌ NON duplicare le traduzioni
   - ✅ Usa SEMPRE Enum con Carbon per i giorni
   - ✅ Centralizza la logica in un unico punto
   - ✅ Sfrutta le funzionalità di Laravel

5. **Gestione Enum Comuni**
   - ❌ NON mettere enum di utilità generale nei moduli specifici
   - ❌ NON duplicare enum comuni in più moduli
   - ✅ Sposta SEMPRE gli enum riutilizzabili in `Modules\Xot\Enums`
   - ✅ Mantieni gli enum specifici del modulo nel modulo
   - ✅ Documenta SEMPRE gli enum in Xot

6. **Gestione Email**
   - ❌ NON creare classi Mailable custom
   - ❌ NON usare workflow per le email
   - ✅ Usa SEMPRE `SpatieEmail` con `MailTemplate`
   - ✅ Definisci i template nel seeder
   - ✅ Usa il locale corretto per le email
   - ✅ Gestisci gli allegati tramite `addAttachments`

7. **Resource Filament**
   - ❌ NON estendere mai direttamente `Filament\Resources\Resource`
   - ✅ Estendere SEMPRE `Modules\Xot\Filament\Resources\XotBaseResource`
   - ✅ Controllare sempre la gerarchia delle classi Resource

8. **Resource XotBaseResource: Proprietà e Metodi Vietati**
   - ❌ NON dichiarare mai:
     - `protected static ?string $navigationIcon`
     - `protected static ?string $navigationGroup`
     - `protected static ?int $navigationSort`
     - `public static function getTableColumns()`
     - `public static function getRelations()`
     - `public static function getPages()` (se restituisce solo index, create, edit)
   - ✅ Queste proprietà/metodi sono gestiti centralmente
   - ✅ Rimuovere e segnalare sempre se trovati

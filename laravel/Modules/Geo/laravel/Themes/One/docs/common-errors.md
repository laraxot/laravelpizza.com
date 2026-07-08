# common errors

## filament form schema senza chiavi (novembre 2025)

- **Sintomo**: nei form Progressioni alcune section risultano vuote o l'ordinamento dei campi è incoerente; PHPStan segnala `array<int, Component>` invece di `array<string, Component>`.
- **Causa**: le risorse Filament del modulo restituivano array numerici; Filament nel tema One non riesce a mappare correttamente le colonne quando il form arriva senza chiavi.
- **Soluzione rapida**: ogni voce del form deve essere referenziata con una chiave stabile (`'general' => Section::make(...)`). Vedi [analisi Progressioni](../../Modules/Progressioni/docs/phpstan-errors-analysis.md#avanzamento--tipizzazione-getformschema-novembre-2025).
- **Impatto tema**: gli stylesheet del tema One assumono la presenza di chiavi per applicare le classi Tailwind dinamiche; senza chiavi, alcuni componenti ricevono classi errate. Dopo l'allineamento delle risorse, non è necessario modificare ulteriormente il tema, ma monitorare questo file per regressioni future.

## GroupColumn con campi relazionali

- **Sintomo**: in tabelle con `GroupColumn` alcune righe risultano vuote quando il campo è relazionale (es. `valutatore.nome_diri`).
- **Causa tecnica**: le colonne figlio nel `GroupColumn` non sono montate alla tabella Filament, quindi `getState()` non funziona. La view usa `data_get()` come fallback per risolvere la dot notation.
- **Soluzione**:
  1. Assicurarsi che la relazione sia caricata con **eager loading** nella query della tabella:
     ```php
     public static function getEloquentQuery(): Builder
     {
         return parent::getEloquentQuery()->with(['valutatore']);
     }
     ```
  2. In alternativa, usare un **accessor piatto** sul modello o una **TextColumn standard** fuori da GroupColumn.
- **Riferimento**: dettagli completi in [group-column-fix](../../Modules/UI/docs/group-column-fix.md).

## modello Scheda su database errato (progressioni)

- **Sintomo**: liste Filament Progressioni vuote, relazioni `valutatore`/`schede` incoerenti, o query che colpiscono il DB `ptv` invece di `progressione`.
- **Causa**: `Scheda` estende `Ptv\Models\BaseScheda` e senza override eredita `protected $connection = 'ptv'`.
- **Soluzione**: `protected $connection = 'progressione';` sul modello consumer. Vedi [database-connection-progressione](../../Modules/Progressioni/docs/database-connection-progressione.md).
- **Impatto tema**: il tema One non configura connessioni DB; il fix è solo lato modulo Progressioni/Ptv. Monitorare questo file se compaiono dati mancanti dopo refactor cross-modulo.

## Resource Filament su connessione errata per `getPages()` cross-module

- **Sintomo**: rotta di un pannello (es. `progressioni/admin/rating-morphs`) va in errore `SQLSTATE[42S02] Base table or view not found ... (Connection: rating, Database: ptv_lara)`, e il route controller punta a `Modules\Rating\...\Pages\ListRatingMorphs` invece che alle Page del modulo corrente.
- **Causa**: il base Resource astratto del modulo Rating (`BaseRatingResource`/`BaseRatingMorphResource`), esteso da Progressioni, override `getPages()` ritornando le Page del modulo Rating → il pannello risolve `Rating\RatingMorph` (conn `rating`) invece di `Progressioni\RatingMorph` (conn `progressione`).
- **Soluzione**: rimuovere `getPages()` dalle basi condivise (auto-resolve via `static::class\Pages\`); ogni modulo consumer deve avere le proprie Page con `$resource` puntato alla Resource del proprio modulo. Vedi [Xot — getPages cross-module](../../Modules/Xot/docs/filament/getpages-redundancy-rule.md) e [database-connection-progressione](../../Modules/Progressioni/docs/database-connection-progressione.md).
- **Nota correlata**: le Resource che estendono `XotBaseResource` non devono dichiarare `$navigationIcon` (né altri attributi gestiti dal LangServiceProvider). Vedi [forbidden-resource-attributes](../../Modules/Xot/docs/forbidden-resource-attributes.md).
- **Impatto tema**: nessuna modifica lato tema; il fix è architetturale lato Resource/Page.

# Checklist Qualità Modulo Rating

Questa checklist serve come riferimento operativo per mantenere il modulo `Rating` allineato agli standard Laraxot (PHPStan Level 10, PSR-12, documentazione aggiornata).

## Qualità del codice

- [ ] Tutti i file PHP espongono `declare(strict_types=1);`.
- [ ] Tutte le funzioni e i metodi hanno tipi di ritorno espliciti.
- [ ] Nessun uso di `mixed` se non strettamente necessario (e documentato).
- [ ] Nessun modello estende direttamente `Illuminate\Database\Eloquent\Model` o `Modules\Xot\Models\XotBaseModel`: si usa sempre il `BaseModel` del modulo.
- [ ] Nessun uso di `property_exists()` sui modelli Eloquent.
- [ ] Nessun override di `table()` o di metodi marcati come `final` nelle XotBase classes.

## Static analysis e testing

- [ ] PHPStan Level 10 per l’intero modulo:
  - comando di riferimento in `laravel/`:  
    `./vendor/bin/phpstan analyse Modules/Rating --memory-limit=-1`
- [ ] Copertura di test Pest per:
  - creazione/aggiornamento/cancellazione di un rating
  - calcolo dei punteggi aggregati principali
  - interazione base di eventuali trait (es. `HasRatingsTrait`).
- [ ] Nessun test escluso da PHPStan: i test devono passare anche l’analisi statica.

## Filament e UI (se presenti)

- [ ] Nessun uso di `->label()`, `->placeholder()`, `->helperText()` nei componenti Filament.
- [ ] I metodi `getTableColumns()`, `getTableFilters()`, `getInfolistSchema()` ritornano sempre `array<string, Component>`.
- [ ] Tutti i Resource/Page/Widget estendono le classi `XotBase*` corrette, non direttamente quelle Filament.
- [ ] Le configurazioni JavaScript embeddate nei widget seguono i pattern documentati (nowdoc/heredoc, nessun copia/incolla fragile).

## Traduzioni e documentazione

- [ ] Traduzioni complete in `Modules/Rating/lang/it/` e, quando necessario, in `lang/en/`.
- [ ] Nessuna data nei nomi file `.md` e nessuna data nel contenuto (le informazioni temporali vivono nei changelog o nella storia git).
- [ ] Documentazione aggiornata in:
  - `Modules/Rating/docs/roadmap.md` (vista di insieme)
  - file specifici in `Modules/Rating/docs/roadmap/`.
- [ ] Link sempre relativi tra documenti (mai URL assolute del filesystem).


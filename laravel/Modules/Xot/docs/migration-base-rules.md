---
title: "MIGRATION BASE RULES"
type: note
status: draft
updated: 2026-10-18
tags: [docs, xot]
qmd: "migration base rules xot"
---
# MIGRATION BASE RULES

## Regola universale
- Usa sempre anonymous class: `return new class extends XotBaseMigration { ... }`
- Non implementare mai il metodo `down` se estendi XotBaseMigration
- Per aggiungere colonne a tabelle esistenti:
  - Copia la migrazione originale, aggiorna il timestamp
  - Aggiungi la colonna in `tableUpdate` solo se non esiste (`if (! $this->hasColumn(...))`)
  - Aggiorna sempre questa doc, la root docs e la doc del modulo

## Motivazione
- Prevenire conflitti di nomi
- Garantire rollback sicuro
- Compliance PHPStan livello 10
- Facilitare troubleshooting e ripresa lavoro

## Checklist rapida
- [ ] Anonymous class
- [ ] Solo metodo `up`
- [ ] Update solo se colonna non esiste
- [ ] Aggiorna sempre la doc

## Cross-reference
- [Update migrazioni Performance](../../Performance/project_docs/migration_update_rules.md)
- [Root MODULE_NAMESPACE_RULES.md](../../../project_docs/MODULE_NAMESPACE_RULES.md)

---

## Backlink
- [Regole update migrazioni Performance](../../Performance/project_docs/migration_update_rules.md) ← questa doc è sempre aggiornata
- [Ripresa lavoro migrazioni in root](../../../project_docs/MODULE_NAMESPACE_RULES.md)

Ultimo aggiornamento: 2025-05-13

---

## Regola generale: Nome univoco per Action custom Filament

- Ogni Action custom Filament deve avere un nome univoco passato a `make()` o impostato come default.
- Vedi esempio e motivazione in [Modules/Performance/project_docs/azioni_organizzativa.md](../../Performance/project_docs/azioni_organizzativa.md#2025-05-14-regola-nome-univoco-per-headeraction-filament)

---

**Backlink modulo Performance:**
- [Modules/Performance/project_docs/azioni_organizzativa.md](../../Performance/project_docs/azioni_organizzativa.md)

---

## Pattern definitivo HeaderAction custom Filament 3

- Segui SEMPRE il pattern documentato in [Modules/Performance/project_docs/azioni_organizzativa.md#2025-05-14-pattern-definitivo-headeraction-custom-filament-3]
- Il pattern Filament 2 (override statico di make) è obsoleto e genera errori: non usarlo mai nei nuovi moduli o refactoring.

---

## Regola colonne tabellari Filament (2025-05-14)

- Le colonne delle tabelle Filament devono essere derivate solo dal modello e dalla migrazione.
- La UI può mostrare solo un sottoinsieme delle colonne, secondo le regole documentate in Performance.
- Ogni modifica va documentata in [Modules/Performance/project_docs/list_table_columns_analysis.md#organizzativacatcoeff]

---

## Regola estensione modelli aggregati (2025-05-15)

- I modelli aggregati e di totali del modulo Performance (es. OrganizzativaTotValutatoreId) devono estendere il `BaseModel` locale (`Modules\Performance\Models\BaseModel`), **NON** `Modules\Xot\Models\BaseModel`.
- **Motivazione**: isolamento, override locale, necessità di personalizzazione e compatibilità con logiche specifiche del modulo Performance.
- **Pattern**: i modelli aggregati e di totali in Performance estendono sempre il BaseModel locale.
- **Anti-pattern**: estendere `Modules\Xot\Models\BaseModel` o centralizzare logiche che devono restare locali.
- **Memoria storica**: rollback della regola il 2025-05-15, documentato in Performance/project_docs/organizzativa-models.md e qui. Precedente regola (2025-05-14) annullata per esigenze di override e compatibilità.
- Ogni violazione va documentata e corretta anche nella root docs.
- Vedi dettaglio e memoria storica in [Modules/Performance/project_docs/organizzativa-models.md](../../Performance/project_docs/organizzativa-models.md#organizzativatotvalutatoreid-regola-di-estensione)
- [docs/links.md root](../../../project_docs/links.md)

> ⚠️ **Warning**: Estendere Xot\BaseModel può causare override indesiderati, perdita di flessibilità e problemi di compatibilità con logiche locali. Seguire sempre la regola sopra per tutti i modelli di totali/aggregati in Performance.

---

## Indici: `ensureIndexes()` (2026-11-04)

`XotBaseMigration::ensureIndexes(array $indexes)` crea solo gli indici che mancano. L'elenco e' `tabella => nome indice => colonne in ordine`. Un indice conta come presente se esiste con quel nome **oppure** sulle stesse colonne nello stesso ordine; se manca una colonna o la tabella, la voce e' saltata (lo schema di un ambiente puo' essere piu' vecchio). Non toglie mai nulla e non va accompagnato da un `down()`.

```php
return new class extends XotBaseMigration
{
    protected ?string $model_class = SurveyPdf::class;   // sceglie la connessione

    public function up(): void
    {
        $this->ensureIndexes([
            'contacts' => ['contacts_survey_pdf_token_index' => ['survey_pdf_id', 'token']],
        ]);
    }
};
```

Quando usarlo: aggiunta di soli indici a tabelle gia' create. La regola "copia la migrazione originale con un timestamp nuovo" vale per le **colonne**; per gli indici la guideline `database-migrations-rules.md` ammette una migrazione a parte ("Index Additions"), e riscrivere un `create_*` da 500 mila righe solo per un indice non porta nulla. Il modello va dichiarato in `$model_class`: il nome del file non e' `create_<modello>_table`, quindi non si puo' derivare.

Ordine delle colonne: prima quelle confrontate con `=`, poi quella usata per intervallo o ordinamento. Prima di proporre un indice controlla il **tipo** delle due colonne messe a confronto: una colonna `varchar` confrontata con un intero fa scandire tutto l'indice (provato su `contacts.survey_pdf_id`, vedi [Quaeris: query lente e indici](../../Quaeris/docs/stories/quaeris-query-lente-e-indici.story.md)).

---

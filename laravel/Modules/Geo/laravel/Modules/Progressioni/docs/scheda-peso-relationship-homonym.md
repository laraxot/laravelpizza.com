# Scheda: omonimia `peso()` — relazione vs calcolo coeff

## Problema

Su `GET /progressioni/admin/schedas/{id}/compila`, `CompilaScheda::fillForm()` chiama
`$this->getRecord()->attributesToArray()`. Laravel serializza gli accessor del modello,
incluso `peso_esperienza_acquisita` definito in `SchedaTrait` (Sigma).

L'accessor usa `$this->peso` come **relazione** verso la tabella `peso` (modello `Pesi`).

In Progressioni esisteva anche `Scheda::peso(array $params): int`, metodo di business che
calcola un coefficiente dalla tabella `coeff`. Eloquent tratta `peso()` come relazione e
la invoca **senza argomenti** → `ArgumentCountError`.

## Scopo di business

| Nome | Ruolo | Consumatori |
|------|--------|-------------|
| `peso()` relazione | Riga pesi criteri per `anno` + `lista_propro` (campo `peso_esperienza_acquisita`, ecc.) | `SchedaTrait`, form compila, stack scheda |
| `resolveCoeffPesoFromParams()` | Calcolo legacy da `propro`/`posfun` su tabella `coeff` | Nessun caller attivo nel codebase (rinominato da `peso(array $params)`) |

In **Performance** la relazione si chiama già `peso(): HasOne` (`RelationshipTrait`).
In Progressioni la stessa relazione era solo `pesi()` (plurale), mentre Sigma usa `$this->peso`.

## Fix applicato

1. `ProgressioniRelationshipTrait::peso(): HasOne` — alias di `pesi()`, allineato a Performance.
2. `Scheda::resolveCoeffPesoFromParams(array $params): int` — ex `peso(array $params)`.

## Verifica

- Aprire `/progressioni/admin/schedas/{id}/compila` senza `ArgumentCountError`.
- Opzionale: `php artisan tinker` → `Scheda::find($id)->peso` restituisce `Pesi|null`.

##Collegamenti

- [METODI_DUPLICATI_ANALISI.md](METODI_DUPLICATI_ANALISI.md) — sezione `peso`
- [wiki/concepts/method-name-homonyms.md](wiki/concepts/method-name-homonyms.md)
- [docs/chat/handoff-scheda-peso-homonym.md](../../../../docs/chat/handoff-scheda-peso-homonym.md)
- Performance: `Modules/Performance/app/Models/Traits/RelationshipTrait.php` (`peso()`)

*Ultimo aggiornamento: 2026-06-15*

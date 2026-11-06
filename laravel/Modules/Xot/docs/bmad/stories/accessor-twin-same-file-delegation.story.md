---
name: accessor-twin-same-file-delegation
status: done
owner: Modules/Xot (regola) + Modules/Sigma, Modules/Ptv (fix)
domain: Models/Traits/Mutators
qmd: "accessor gemello stesso file delega getNomeAttribute getNome"
---

# Accessor => gemello stesso file + delega

## Regola (chiara dal committente)

Per ogni `get<Nome>Attribute()`:

1. nel **stesso file** dove e' definito l'accessor deve esistere `get<Nome>()`;
2. l'accessor deve **chiamare** `$this->get<Nome>()` al suo interno.

Accessor = cache-hit su `$value` / `$this->attributes['colonna'] ?? null` + persistenza
(`update()` in `withoutEvents` o `saveQuietly`). Gemello = calcolo puro, `public`,
senza side effect. Forma canonica:

```php
public function getGgParttimevertAnnoAttribute(?float $value): ?float
{
    if ($value !== null) {
        return $value;
    }

    $value = $this->getGgParttimevertAnno();
    // persistenza...
    return $value;
}

public function getGgParttimevertAnno(): float
{
    // solo calcolo
}
```

Nota: e' piu' stretto di `xot:check-accessor-twins` (che verifica solo
`hasMethod` sulla classe composta, anche cross-trait). Il check severo e'
`bashscripts/tools/accessor-twins/check.py` (stesso file + `$this->get<Nome>()`).

## Audit

`python3 bashscripts/tools/accessor-twins/check.py laravel/Modules`
(443 file in app/Models, scope modificato da `app/**` a `app/Models/**` per
escludere helper non-accessor: `getTableRecordTitleAttribute` Filament,
`SafeAttributeCastAction::*Attribute`, `HasSchemalessAttributes::getExtraAttribute`,
`HasProfilePhotoContract::getProfilePhotoUrlAttribute`; aggiunto strip dei commenti
che generava falsi positivi su blocchi `/* ... */`).

### Violazioni residue (8)

| File | Violazione |
|------|-----------|
| `Modules/Sigma/app/Models/Traits/Mutators/EnteMatrMutator.php` | 7 accessor (`getCognome`, `getEmail`, `getSesso`, `getCodiceFiscale`, `getInail`, `getNome`, `getTitoloDiStudio`) con gemello presente ma **logica duplicata inline** invece di delegare |
| `Modules/Ptv/app/Models/BaseStabiDirigente.php` | `getNomeDiriAttribute()` senza gemello `getNomeDiri()` nello stesso file |

### Gia' conforme

`Modules/Sigma/.../EnteMatrAnnoMutator.php`: gemelli `getPercPTimeYear()`,
`getPercParttimeAnno()`, `getGgParttimevertAnno()`, `getGgPTimeVertYear()`,
`getGgParttimevert()`, `getPercParttime()` creati e accessor allineati
(`public`, `?float $value`, delega `$this->getX()`).

## Debiti / segnalazioni collaterali

- `Modules/Incentivi/app/Models/StabiDirigente.php`: due accessor duplicati
  commentati (`getNomeDiriAttribute`, `getNomeStabiAttribute` in `/* */`) —
  dead code da rimuovere. Il gemello `getNomeDiri()` contiene `random_int()`:
  casualita' dentro un getter, da segnalare.
- `Modules/Performance/app/Models/IndividualePesi.php`: ~130 righe di accessor
  commentati — dead code.
- `Modules/Sigma/app/Models/Traits/Mutators/EnteMatrMutator.php`:
  `getTitoloDiStudioAttribute()` esegue DDL a runtime se la colonna manca
  (debito gia' noto in `Modules/Sigma/docs/bmad/accessor-twin-method.md`).
- Bridge `bashscripts/ai/wiki/rules/accessor-twin-method.md` punta a
  `docs/wiki/rules/accessor-twin-method.md` inesistente: link canonico rotto,
  corretto puntando ai documenti reali.

## Fix applicati

- [x] `check.py`: scope `app/Models/**` + strip commenti
- [x] `EnteMatrAnnoMutator`: gemelli + delega + visibility `public` uniforme
- [x] `EnteMatrMutator`: 7 accessor delegano ai gemelli (visibility `public`);
  persistenza saltata sul sentinel `'---'` per `cognome`/`nome` (il gemello lo
  restituisce come placeholder, non va scritto in colonna)
- [x] `BaseStabiDirigente`: mutator+relazioni estratti in trait dedicati
  (`StabiDirigenteMutator`, `StabiDirigenteRelationship`), modello alleggerito
- [x] `IndividualePesi`: ~130 righe accessor commentati rimosse; nuovi trait
  `IndividualePesiMutator` + `IndividualePesiRelationship`
- [x] Incentivi `StabiDirigente`: blocco accessor commentato rimosso
- [x] Bridge `bashscripts/ai/wiki/rules/accessor-twin-method.md` ripuntato ai
  canonici reali (link rotto corretto)
- [x] Concetto `accessor-auto-persistence.md`: aggiunta regola severa
  stesso-file + delega + trait dedicati

## Esito

`check.py` → **0 violazioni** su 953 file `app/Models/**`.
Falsi positivi esclusi dallo scope: `SafeEloquentCastAction` (Actions),
`HasXotTable::getTableRecordTitleAttribute` (Filament), `HasSchemalessAttributes`
(traits extra-model).

## Verifica

- `python3 bashscripts/tools/accessor-twins/check.py laravel/Modules` → 0 violazioni
- `php -l` sui file toccati
- `phpstan analyse` sui moduli toccati (Sigma, Ptv, Incentivi, Performance)
- Pest: `Modules/Sigma/tests/Unit/AccessorTwinMethodTest.php` (skip se DB
  `generale` non disponibile — host con dati sacri)

## Riferimenti

- Regola concetto: `bashscripts/ai/wiki/concepts/accessor-auto-persistence.md`
- Doc modulo: `laravel/Modules/Sigma/docs/bmad/accessor-twin-method.md`
- Comando classe: `php artisan xot:check-accessor-twins` (Xot)
- Check stretto: `bashscripts/tools/accessor-twins/check.py`

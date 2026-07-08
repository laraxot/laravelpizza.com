# Censimento Metodi Relazione Duplicati

**Data**: 2026-06-15
**Scope**: Tutti i moduli (`Modules/`) e temi (`Themes/`)

---

## Modulo Sigma (12 metodi duplicati)

### codici (×4) — HasOne

| File | Riga |
|---|---|
| `Asz00k1.php` | 208 |
| `Asz00f.php` | 194 |
| `Wgiu03f.php` | 114 |
| `Mov01k2.php` | 101 |

**Azione**: Creare trait `CodiciRelationship` con `hasManyByEnteMatr(Codici::class)` o `hasOneByEnteMatr()`.

---

### wstr01lx (×3) — HasMany

| File | Riga |
|---|---|
| `Traits/Relationships/EnteMatrRelationship.php` | 24 |
| `Wstr02f.php` | 242 |
| `Wmen00f.php` | 119 |

**Nota**: `Wstr02f` e `Wmen00f` hanno FK diverse (`wtmatr`/`enteap`). Override legittimo.

---

### qua00f (×3) — HasMany

| File | Riga |
|---|---|
| `Traits/Relationships/EnteMatrRelationship.php` | 56 |
| `Asz00k1.php` | 231 |
| `Rep00f.php` | 255 |

**Nota**: `Asz00k1`/`Rep00f` possono avere scope aggiuntivi. Verificare se eliminabili in favore del trait.

---

### anag (×3) — HasOne/BelongsTo

| File | Riga |
|---|---|
| `Traits/Relationships/EnteMatrRelationship.php` | 40 |
| `Wstr02f.php` | 237 |
| `Wstr01lx.php` | 110 |

**Nota**: `Wstr02f`/`Wstr01lx` usano FK differenti. Override legittimo.

---

### tqu00f (×2) — HasOne

| File | Riga |
|---|---|
| `Traits/Relationships/TquRelationship.php` | 18 |
| `Qua00f.php` | 269 |

---

### reparts (×2) — HasMany

| File | Riga |
|---|---|
| `Rep00f.php` | 218 |
| `Traits/Relationships/EnteStabiRelationship.php` | 15 |

---

### rep00f (×2) — HasMany

| File | Riga |
|---|---|
| `Qua00f.php` | 308 |
| `Traits/Relationships/EnteMatrRelationship.php` | 61 |

---

### qua00fYear (×2) — HasMany

| File | Riga |
|---|---|
| `Traits/Relationships/EnteMatrYearRelationship.php` | 21 |
| `Traits/Relationships/EnteMatrAnnoRelationship.php` | 22 |

**Nota**: Due trait diversi definiscono la stessa relazione. Uno è probabilmente legacy.

---

### ana10f (×2) — HasOne

| File | Riga |
|---|---|
| `Traits/Relationships/EnteMatrRelationship.php` | 51 |
| `Qua00f.php` | 286 |

---

### ana02f (×2) — HasMany

| File | Riga |
|---|---|
| `Traits/Relationships/EnteMatrRelationship.php` | 45 |
| `Qua00f.php` | 297 |

---

### Tqu00f (×2) — HasOne (case diverso da tqu00f!)

| File | Riga |
|---|---|
| `Qua03f.php` | 212 |
| `Qua00k1.php` | 159 |

**Nota**: Nome con maiuscola `Tqu00f` vs `tqu00f`. Incoerenza naming.

---

### stabiDirigente (×2) — HasOne

| File | Riga |
|---|---|
| `Traits/Relationships/SchedaRelationship.php` | 45 |
| `Traits/Relationships/SchedaRelationship.php` | 62 (commentato) |

**Nota**: Versione commentata, probabilmente legacy.

---

## Altri Moduli (Top duplicati cross-modulo)

### benificiariProgressione (×4)

| Modulo/File | Tipo |
|---|---|
| `Ptv/Models/BaseStabiDirigente.php` | HasMany |
| `Ptv/Models/Valutatore.php` | HasMany |
| `Progressioni/Models/StabiDirigente.php` | HasMany |
| `Progressioni/Models/Valutatore.php` | HasMany |

**Azione**: Trait condiviso tra Ptv e Progressioni.

---

### criteriEsclusione (×4)

| Modulo/File | Tipo |
|---|---|
| `Performance/Models/BaseIndividualeModel.php` | HasMany |
| `Performance/Models/Traits/RelationshipTrait.php` | HasMany |
| `Performance/Models/Organizzativa.php` | HasMany |
| `Progressioni/Models/Traits/ProgressioniRelationshipTrait.php` | HasMany |

---

### valutatore (×4)

| Modulo/File | Tipo |
|---|---|
| `Ptv/Models/Traits/HasValutatore.php` | BelongsTo |
| `Performance/Models/IndividualeTotValutatoreId.php` | BelongsTo |
| `Performance/Models/BaseIndividualeModel.php` | BelongsTo |
| `Progressioni/Models/Traits/ProgressioniRelationshipTrait.php` | BelongsTo |

**Azione**: Trait `HasValutatore` esiste in Ptv — gli altri moduli dovrebbero usarlo.

---

### cards (×3) — HasMany

| Modulo/File | Tipo |
|---|---|
| `Performance/Models/BaseIndividualeModel.php` | HasMany |
| `Performance/Models/Traits/RelationshipTrait.php` | HasMany |
| `Performance/Models/Organizzativa.php` | HasMany |

---

### repart (×3) — HasOne

| Modulo/File | Tipo |
|---|---|
| `Incentivi/Models/StabiDirigente.php` | HasOne |
| `Ptv/Models/BaseStabiDirigente.php` | HasOne |
| `Ptv/Models/Valutatore.php` | HasOne |

---

### myLogs (×3) — MorphMany

| Modulo/File | Tipo |
|---|---|
| `Ptv/Models/Traits/HasMyLogs.php` | MorphMany |
| `Progressioni/Models/Traits/ProgressioniRelationshipTrait.php` | HasMany (!) |
| `Progressioni/Models/Traits/ProgressioniRelationshipTrait.php` | MorphMany |

**Nota**: `Progressioni` ha DUE definizioni nello stesso file. Una è `HasMany` (sbagliata), l'altra `MorphMany`. Bug.

---

### profile (×4) — HasOne/BelongsTo (tipi misti!)

| Modulo/File | Tipo |
|---|---|
| `User/Models/BaseUser.php` | HasOne |
| `User/Models/DeviceUser.php` | BelongsTo |
| `Rating/Models/RatingMorph.php` | BelongsTo |
| `Xot/Contracts/UserContract.php` | HasOne (interface) |

---

### schede (×8)

Cross-modulo: Performance, Ptv, Progressioni. Usano tutti `HasMany` verso tabelle schede valutazione.

---

### stabiDirigente (×6)

Cross-modulo: Performance, Ptv, Sigma, Progressioni. Pattern condiviso per relazione dirigente-stabili.

---

### user/users (×8 ciascuno)

Cross-modulo: User, Tenant, Incentivi, Performance. Pattern standard Laravel, non problematico.

---

## Riflessioni

### Cause della duplicazione

1. **Modelli cross-modulo senza trait condivisi**: `StabiDirigente` esiste in 3 moduli con le stesse relazioni
2. **Override per FK diverse**: legittimi in Sigma (es. `Wstr01lx` usa `wtmatr`/`enteap`)
3. **Trait non usati**: `EnteMatrRelationship` definisce relazioni che poi vengono ridefinite nei modelli concreti
4. **Legacy**: trait `EnteMatrAnnoRelationship` vs `EnteMatrYearRelationship` fanno la stessa cosa
5. **Naming incoerente**: `Tqu00f` (maiuscolo) vs `tqu00f` (minuscolo)

### Regola da applicare

> Se un modello usa un trait che definisce una relazione, **NON** ridefinire la stessa relazione nel modello.
> Se serve logica aggiuntiva (scope), usare metodi separati (es. `qua00fActive()`) o scoped relationship.

### Priorità di pulizia

1. **Sigma**: eliminare relazioni ridefinite in modelli che usano `EnteMatrRelationship`
2. **Performance/Progressioni**: unificare `criteriEsclusione`, `valutatore`, `cards` in trait condivisi
3. **Ptv/Progressioni/Incentivi**: unificare `benificiariProgressione`, `repart` in trait Ptv
4. **Naming**: rinominare `Tqu00f` → `tqu00f` per coerenza PSR

---

*Generato automaticamente da analisi grep. Aggiornare dopo refactoring.*

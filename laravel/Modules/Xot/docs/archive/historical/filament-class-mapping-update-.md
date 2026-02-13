# Aggiornamento Mapping Classi Filament - 2025-12-23

**Obiettivo**: Verificare e correggere mapping classi nel file `filament_class.txt`

## ⚠️ Classi Aggiunte al Mapping che NON Esistono

L'utente ha aggiunto al mapping le seguenti classi che **non esistono** nel codebase:

### 1. XotBaseGroup (Schemas Components)

**Mapping aggiunto**:
```
| `Filament\Schemas\Components\Group` | `Modules\Xot\Filament\Schemas\Components\XotBaseGroup` |
```

**Realtà Codebase**:
- ❌ `XotBaseGroup` **NON esiste**
- ✅ Esiste solo `XotBaseSection` in `Modules/Xot/app/Filament/Schemas/Components/`
- 📁 Directory `Schemas/Components/` contiene solo: `XotBaseSection.php`

**Uso Reale**:
- I componenti Group vengono usati direttamente da Filament quando necessario
- Non ci sono classi custom che estendono Group nel codebase

### 2. XotBaseRadio (Forms Components)

**Mapping aggiunto**:
```
| `Filament\Forms\Components\Radio` | `Modules\Xot\Filament\Forms\Components\XotBaseRadio` |
```

**Realtà Codebase**:
- ❌ `XotBaseRadio` **NON esiste**
- ✅ Componenti Radio estendono direttamente `Filament\Forms\Components\Radio`:
  - `RadioBadge` → `Filament\Forms\Components\Radio`
  - `RadioIcon` → `Filament\Forms\Components\Radio`
  - `RadioImage` → `Filament\Forms\Components\Radio`

**Uso Reale**:
- I componenti Radio custom sono nel modulo UI, non Xot
- Estendono direttamente `Filament\Forms\Components\Radio`

### 3. XotBaseSelect (Forms Components)

**Mapping aggiunto**:
```
| `Filament\Forms\Components\Select` | `Modules\Xot\Filament\Forms\Components\XotBaseSelect` |
```

**Realtà Codebase**:
- ❌ `XotBaseSelect` **NON esiste** per Forms Components
- ✅ Esiste `XotBaseSelectColumn` per **Tables Columns** (diverso!)
- ✅ Componenti Select estendono direttamente `Filament\Forms\Components\Select`:
  - `LocationSelector` → Usa `Filament\Forms\Components\Select`
  - `SelectState` → Estende `Filament\Forms\Components\Select`

**Uso Reale**:
- I componenti Select custom usano direttamente Filament Select
- Solo Tables Columns hanno XotBaseSelectColumn

## ✅ Classi Base Forms Components Esistenti

Solo queste classi base esistono per Forms Components in Xot:

- `XotBaseField` ✅ (estende `Filament\Forms\Components\Field`)
- `XotBaseFormComponent` ✅ (estende `Filament\Forms\Components\Field`)
- `XotBasePlaceholder` ✅ (estende `Filament\Forms\Components\Placeholder`)

## ✅ Classi Base Schemas Components Esistenti

Solo questa classe base esiste per Schemas Components in Xot:

- `XotBaseSection` ✅ (estende `Filament\Schemas\Components\Section`)

## 📋 Situazione Attuale Codebase

### Forms Components Custom (Modulo UI)

I componenti Forms custom **estendono direttamente Filament**:

- `RadioBadge` → `Filament\Forms\Components\Radio` ✅
- `RadioIcon` → `Filament\Forms\Components\Radio` ✅
- `RadioImage` → `Filament\Forms\Components\Radio` ✅
- `LocationSelector` → Usa `Filament\Forms\Components\Select` ✅
- `SelectState` → Estende `Filament\Forms\Components\Select` ✅
- `AddressField` → Estende `Filament\Forms\Components\Field` ✅
- `OpeningHoursField` → Estende `Filament\Forms\Components\Field` ✅

### Tables Columns (Modulo Xot)

Le Tables Columns hanno classi base:

- `XotBaseSelectColumn` ✅ (estende `Filament\Tables\Columns\SelectColumn`)
- `XotBaseColumn` ✅
- `XotBaseIconColumn` ✅
- `XotBaseColumnGroup` ✅

**NOTA**: `XotBaseSelectColumn` è per **Tables**, non per **Forms**!

## 🎯 Raccomandazione

### Opzione 1: Rimuovere Classi Inesistenti dal Mapping (CONSIGLIATO)

Rimuovere dal mapping tutte le classi che non esistono:

```diff
- ### Schemas Components
- | `Filament\Schemas\Components\Group` | `Modules\Xot\Filament\Schemas\Components\XotBaseGroup` |
-
- ### Forms Components
- | `Filament\Forms\Components\Radio` | `Modules\Xot\Filament\Forms\Components\XotBaseRadio` |
- | `Filament\Forms\Components\Select` | `Modules\Xot\Filament\Forms\Components\XotBaseSelect` |
```

**Motivazione**:
- Le classi non esistono
- I componenti funzionano estendendo direttamente Filament
- Non ci sono funzionalità comuni da centralizzare
- Seguire "mai estendere Filament" per Forms Components base non è critico come per Resources/Pages/Widgets

### Opzione 2: Creare le Classi Base Mancanti

Se si vuole seguire rigorosamente la regola "mai estendere Filament direttamente":

1. Creare `XotBaseGroup` estendendo `Filament\Schemas\Components\Group`
2. Creare `XotBaseRadio` estendendo `Filament\Forms\Components\Radio`
3. Creare `XotBaseSelect` estendendo `Filament\Forms\Components\Select`
4. Refactorare tutti i componenti esistenti

**Nota**: Questo richiede refactoring significativo senza benefici immediati.

## 💡 Considerazioni Filosofiche

### Regola "Mai Estendere Filament Direttamente"

Questa regola è **più stringente** per:
- ✅ **Resources, Pages, Widgets, Actions** → Sempre XotBase (CRITICO)
- ✅ **Schemas Components custom** → XotBaseSection esiste
- ⚠️ **Forms Components "core" standard** (Select, Radio, CheckboxList) → Attualmente accettabile estendere direttamente
- ✅ **Forms Components "custom"** → Usano XotBaseField/XotBaseFormComponent quando appropriato

### Perché Forms Components Base sono Accettabili?

1. **Non hanno logica comune** da centralizzare
2. **Funzionano bene** estendendo direttamente Filament
3. **Non creano dipendenze complesse** come Resources/Pages
4. **Sono più semplici** da mantenere senza layer aggiuntivo

## 📝 Decisione Finale

**CONSIGLIATO**: Opzione 1 (Rimuovere mapping inesistenti)

Il mapping deve riflettere la **realtà del codice**, non aspirazioni future. Se in futuro si vorrà creare queste classi base, si potrà:
1. Crearle seguendo il pattern esistente
2. Refactorare i componenti
3. Aggiornare il mapping

---

**Conclusione**: Le classi `XotBaseGroup`, `XotBaseRadio`, e `XotBaseSelect` **non esistono** nel codebase e devono essere **rimosse dal mapping** per mantenere coerenza con la realtà del codice.

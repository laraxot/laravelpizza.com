# Correzione Mapping Classi Filament - 2025-12-23

**Data**: 2025-12-23
**Obiettivo**: Correggere mapping classi inesistenti nel file `filament_class.txt`

## ⚠️ Problema Identificato

L'utente ha aggiunto al mapping classi che **non esistono** nel codebase:

1. `XotBaseGroup` (Schemas Components) - ❌ NON esiste
2. `XotBaseRadio` (Forms Components) - ❌ NON esiste
3. `XotBaseSelect` (Forms Components) - ❌ NON esiste

## ✅ Verifica Codebase

### Schemas Components in Xot

**Directory**: `Modules/Xot/app/Filament/Schemas/Components/`

**Contenuto**:
- ✅ `XotBaseSection.php` (esiste)
- ❌ `XotBaseGroup.php` (NON esiste)

**Conclusione**: Solo `XotBaseSection` esiste per Schemas Components.

### Forms Components in Xot

**Directory**: `Modules/Xot/app/Filament/Forms/Components/`

**Contenuto**:
- ✅ `XotBaseField.php` (esiste)
- ✅ `XotBaseFormComponent.php` (esiste)
- ✅ `XotBasePlaceholder.php` (esiste)
- ❌ `XotBaseRadio.php` (NON esiste)
- ❌ `XotBaseSelect.php` (NON esiste)

**Conclusione**: Solo classi base generiche esistono, non versioni specifiche per Radio/Select.

### Uso Reale nel Codebase

**Radio Components (Modulo UI)**:
- `RadioBadge` → Estende `Filament\Forms\Components\Radio` direttamente
- `RadioIcon` → Estende `Filament\Forms\Components\Radio` direttamente
- `RadioImage` → Estende `Filament\Forms\Components\Radio` direttamente

**Select Components**:
- `LocationSelector` → Usa `Filament\Forms\Components\Select` direttamente
- `SelectState` → Estende `Filament\Forms\Components\Select` direttamente

**NOTA**: Esiste `XotBaseSelectColumn` per **Tables Columns**, ma NON per Forms Components.

## 🔧 Correzione Applicata

### Mapping Corretto

Il mapping è stato corretto per riflettere la realtà:

1. **Rimossi mapping inesistenti**:
   - `XotBaseGroup` → Rimosso (non esiste)
   - `XotBaseRadio` → Rimosso (non esiste)
   - `XotBaseSelect` → Rimosso (non esiste)

2. **Aggiunta nota esplicativa**:
   - Spiegazione che Forms Components "core" possono essere estesi direttamente
   - Elenco classi base esistenti
   - Esempi di uso reale

## 💡 Filosofia

### Regola "Mai Estendere Filament Direttamente"

Questa regola è **applicata diversamente** per diversi tipi di componenti:

1. **Resources, Pages, Widgets, Actions** → **SEMPRE** XotBase (CRITICO)
2. **Schemas Components** → XotBase quando esiste (es. XotBaseSection)
3. **Forms Components "core"** → Accettabile estendere direttamente Filament
4. **Forms Components "custom"** → Usano XotBaseField/XotBaseFormComponent quando appropriato

### Perché Forms Components Base sono Accettabili?

- Non hanno logica comune da centralizzare
- Funzionano bene estendendo direttamente Filament
- Non creano dipendenze complesse
- Sono più semplici da mantenere senza layer aggiuntivo

## 📋 Classi Base Esistenti - Riepilogo

### Schemas Components (Xot)
- ✅ `XotBaseSection` (estende `Filament\Schemas\Components\Section`)

### Forms Components (Xot)
- ✅ `XotBaseField` (estende `Filament\Forms\Components\Field`)
- ✅ `XotBaseFormComponent` (estende `Filament\Forms\Components\Field`)
- ✅ `XotBasePlaceholder` (estende `Filament\Forms\Components\Placeholder`)

### Tables Columns (Xot)
- ✅ `XotBaseSelectColumn` (estende `Filament\Tables\Columns\SelectColumn`)
- ✅ `XotBaseColumn`
- ✅ `XotBaseIconColumn`
- ✅ `XotBaseColumnGroup`

## 🔮 Futuro

Se in futuro si volesse creare queste classi base:

1. Creare `XotBaseGroup` estendendo `Filament\Schemas\Components\Group`
2. Creare `XotBaseRadio` estendendo `Filament\Forms\Components\Radio`
3. Creare `XotBaseSelect` estendendo `Filament\Forms\Components\Select`
4. Refactorare tutti i componenti esistenti
5. Aggiornare il mapping

**Fino ad allora**, il mapping deve riflettere la realtà del codice esistente.

---

**Stato**: ✅ Mapping corretto per riflettere codice esistente
**Data Correzione**: 2025-12-23

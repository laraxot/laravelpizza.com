# Verifica Mapping Classi Filament → XotBase

**Obiettivo**: Verificare coerenza tra file di regole e codice esistente

## ⚠️ Inconsistenze Identificate

### Classi nel Mapping che NON Esistono

1. **`Modules\Xot\Filament\Forms\Components\XotBaseSelect`**
   - **Nel mapping**: Presente
   - **Nel codice**: ❌ Non esiste
   - **Uso reale**: Componenti estendono direttamente `Filament\Forms\Components\Select`

2. **`Modules\Xot\Filament\Forms\Components\XotBaseCheckboxList`**
   - **Nel mapping**: Presente
   - **Nel codice**: ❌ Non esiste
   - **Uso reale**: Componenti estendono direttamente `Filament\Forms\Components\CheckboxList`

3. **`Modules\UI\Filament\Forms\Components\UIBaseRadio`**
   - **Nel mapping**: Presente (aggiunta recentemente)
   - **Nel codice**: ❌ Non esiste
   - **Uso reale**:
     - `RadioBadge` estende `Filament\Forms\Components\Radio`
     - `RadioIcon` estende `Filament\Forms\Components\Radio`
     - `RadioImage` estende `Filament\Forms\Components\Radio`

## ✅ Classi Base Esistenti (Xot/Forms/Components)

- `XotBaseField` ✅
- `XotBaseFormComponent` ✅
- `XotBasePlaceholder` ✅

## 📋 Componenti UI che Estendono Direttamente Filament

### Forms Components (UI Module)

- `RadioBadge` → `Filament\Forms\Components\Radio`
- `RadioIcon` → `Filament\Forms\Components\Radio`
- `RadioImage` → `Filament\Forms\Components\Radio`
- `RadioCollection` → `Filament\Forms\Components\Field`
- `AddressField` → `Filament\Forms\Components\Field`
- `OpeningHoursField` → `Filament\Forms\Components\Field`
- `TreeField` → `Filament\Forms\Components\Field`

## 🎯 Decisione Necessaria

Il file `bashscripts/prompts/filament_class.txt` contiene un mapping che non corrisponde alla realtà del codice.

### Opzione 1: Rimuovere Classi Inesistenti dal Mapping

Rimuovere dal mapping le classi che non esistono:
- `XotBaseSelect` → Rimuovere (non esiste)
- `XotBaseCheckboxList` → Rimuovere (non esiste)
- `UIBaseRadio` → Rimuovere (non esiste)

### Opzione 2: Creare le Classi Base Mancanti

Creare le classi base mancanti seguendo il pattern esistente:
- Creare `XotBaseSelect` estendendo `Filament\Forms\Components\Select`
- Creare `XotBaseCheckboxList` estendendo `Filament\Forms\Components\CheckboxList`
- Creare `UIBaseRadio` estendendo `Filament\Forms\Components\Radio` (in modulo UI)
- Refactorare i componenti esistenti per estendere le classi base

## 📝 Raccomandazione

**Opzione 1** (Rimuovere mapping inesistenti) se:
- Le classi base non sono necessarie
- I componenti funzionano bene estendendo direttamente Filament
- Non ci sono funzionalità comuni da centralizzare

**Opzione 2** (Creare classi base) se:
- Si vuole seguire rigorosamente la regola "mai estendere Filament direttamente"
- Ci sono funzionalità comuni da centralizzare
- Si vuole preparare per future modifiche/override

## ⚠️ Nota Importante

La regola "mai estendere Filament direttamente" sembra essere più stringente per:
- Resources, Pages, Widgets, Actions (sempre XotBase)
- Forms Components specifici (alcuni hanno base, altri no)

Potrebbe essere che Forms Components più "specializzati" siano accettabili estendendo direttamente Filament, mentre quelli "core" (Select, CheckboxList, Radio) dovrebbero avere base.

# Nota: Forms Components Base Classes

**Data**: 2025-12-23
**Status**: Mapping aggiornato per riflettere realtà codice

## 📋 Classi Rimosse dal Mapping

Le seguenti classi sono state rimosse dal mapping perché **non esistono nel codice**:

1. **`Modules\Xot\Filament\Forms\Components\XotBaseSelect`**
   - **Motivo**: Classe non esiste
   - **Realtà**: Componenti usano direttamente `Filament\Forms\Components\Select`

2. **`Modules\Xot\Filament\Forms\Components\XotBaseCheckboxList`**
   - **Motivo**: Classe non esiste
   - **Realtà**: Componenti usano direttamente `Filament\Forms\Components\CheckboxList`

3. **`Modules\UI\Filament\Forms\Components\UIBaseRadio`**
   - **Motivo**: Classe non esiste
   - **Realtà**: Componenti Radio (`RadioBadge`, `RadioIcon`, `RadioImage`) estendono direttamente `Filament\Forms\Components\Radio`

## ✅ Classi Base Forms Components Esistenti

Solo queste classi base esistono per Forms Components:

- `Modules\Xot\Filament\Forms\Components\XotBaseField`
- `Modules\Xot\Filament\Forms\Components\XotBaseFormComponent`
- `Modules\Xot\Filament\Forms\Components\XotBasePlaceholder`

## 💡 Considerazioni

### Forms Components Specializzati

I Forms Components "specializzati" (Select, CheckboxList, Radio) attualmente:
- Estendono direttamente Filament
- Funzionano correttamente
- Non hanno funzionalità comuni da centralizzare

### Regola "Mai Estendere Filament Direttamente"

Questa regola è **più stringente** per:
- ✅ Resources, Pages, Widgets, Actions → Sempre XotBase
- ⚠️ Forms Components "core" standard (Select, CheckboxList, Radio) → Attualmente accettabile estendere direttamente
- ✅ Forms Components "custom" → Usano XotBaseField/XotBaseFormComponent

## 🔮 Futuro

Se in futuro si volesse creare queste classi base:
1. Creare `XotBaseSelect` estendendo `Filament\Forms\Components\Select`
2. Creare `XotBaseCheckboxList` estendendo `Filament\Forms\Components\CheckboxList`
3. Creare `UIBaseRadio` estendendo `Filament\Forms\Components\Radio`
4. Refactorare tutti i componenti per estendere le classi base

Per ora, il mapping riflette la realtà del codice.

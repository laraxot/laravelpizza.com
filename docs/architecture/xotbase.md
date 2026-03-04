# XotBase Architecture & Extension Rules

> **"Mai estendere Filament direttamente - Sempre tramite XotBase"**
> *XotBase è il nostro contratto con il futuro.*

## 🎯 Il "Perché" dell'Architettura
XotBase funge da wrapper per tutti i componenti Filament nel progetto Laraxot. Centralizzando le estensioni di base, riduciamo il tempo di manutenzione per i major update di Filament del **95%+**.

## 🚨 Regola Inviolabile
È **VIETATO** estendere classi `Filament\*` direttamente nelle classi dei moduli. Ogni componente (Action, Page, Resource, Widget, RelationManager) deve estendere la corrispondente classe `XotBase*` situata in `Modules\Xot\Filament\`.

## 📋 Mappatura delle Classi

| Componente Filament | Classe XotBase |
| :--- | :--- |
| `Filament\Actions\Action` | `Modules\Xot\Filament\Actions\XotBaseAction` |
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\RelationManagers\RelationManager` | `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager` |

## 🛠️ Linee Guida per lo Sviluppo

### 1. Traduzioni Automatiche (Laraxot Zen)
Non utilizzare mai `->label()`, `->placeholder()`, o `->tooltip()` con stringhe dirette. Il `LangServiceProvider` risolve automaticamente i nomi dei campi e delle azioni usando la struttura:
`{modulo}::{resource}.fields.{campo}.label`

### 2. Metodi Obbligatori
Alcune classi `XotBase` impongono pattern specifici per garantire la conformità con PHPStan Level 10:
- **XotBaseWidget**: Deve implementare `public function getFormSchema(): array`.
- **XotBaseResource**: Deve implementare `public static function getFormSchema(): array` (centralizzato).

### 3. Namespace Standard
Assicurati di usare i namespace corretti. Mai includere `App` nel percorso se sei all'interno di un modulo (es. `Modules\Xot\Filament\...` non `Modules\Xot\App\Filament\...`).

## 🔍 Verifica Compliance
Puoi verificare la conformità del tuo modulo con il seguente comando:
```bash
grep -r "extends Filament\\" Modules/[YourModule] | grep -v "XotBase"
```
L'output deve essere vuoto.

---

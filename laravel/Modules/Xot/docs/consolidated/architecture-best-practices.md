## Convenzioni di naming per le azioni (Actions)

Per tutte le azioni che operano su chiavi di aggregazione specifiche (es. stabi, valutatore_id, ecc.), si raccomanda l'uso esplicito del suffisso `By<Chiave>` nel nome della classe. Esempio:
- `UpdateRestiPondByValutatoreIdAction` (corretto)
- `UpdateRestiPondValutatoreIdAction` (da evitare)

Questa convenzione migliora la leggibilità e la chiarezza del codice, rendendo immediatamente evidente la logica di aggregazione utilizzata.

**Collegamento bidirezionale:**
- [Motivazione e applicazione nel modulo Performance](../../Performance/project_docs/azioni_organizzativa.md)

## Memo e regole operative permanenti (per tutti i moduli che seguono Xot)

### 🚨 REGOLA CRITICA FONDAMENTALE: Estensione Classi XotBase

**MAI ESTENDERE CLASSI FILAMENT DIRETTAMENTE - SEMPRE USARE XOTBASE***

❌ **VIETATO**:
```php
class Dashboard extends Filament\Pages\Dashboard
class MyResource extends Filament\Resources\Resource
class MyWidget extends Filament\Widgets\Widget
class MyPage extends Filament\Pages\Page
```

✅ **OBBLIGATORIO**:
```php
class Dashboard extends Modules\Xot\Filament\Pages\XotBaseDashboard
class MyResource extends Modules\Xot\Filament\Resources\XotBaseResource
class MyWidget extends Modules\Xot\Filament\Widgets\XotBaseWidget
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage
class AdminPanelProvider extends Modules\Xot\Providers\Filament\XotBasePanelProvider
```

**MOTIVAZIONE**: Le classi XotBase replicano la struttura Filament originale ma forniscono funzionalità aggiuntive specifiche del progetto, garantiscono consistenza tra moduli e permettono modifiche centralizzate.

**QUESTA REGOLA HA PRIORITÀ ASSOLUTA SU QUALSIASI ALTRA CONSIDERAZIONE!**

### Altre Regole Operative

- **Un solo model per ogni concetto aggregato**: per ogni tipo di aggregazione (es. valutatore_id, stabi, ecc.), deve esistere un solo model, con nome e tabella coerenti e documentati. Usare sempre `BaseModel` come classe base.
- **Un solo file per ogni azione di aggregazione**: mantenere solo la versione con il suffisso `By<Chiave>` (es. `ByValutatoreId`, `ByStabi`) per chiarezza, coerenza e ricerca.
- **Tutte le azioni e i model devono essere documentati** e collegati alle regole generali del progetto (vedi root docs e docs di ogni modulo).
- **Le duplicazioni vanno eliminate**: ogni refactoring deve essere documentato con motivazione e percorso nella sezione dedicata.
- **Tipizzazione rigorosa**: tutto il codice deve essere conforme a phpstan livello 10.
- **Collegamenti rapidi**:
  - [Documentazione generale e convenzioni di progetto](../../../../project_docs/coding-standards.md)
  - [Esempio e memo nel modulo Performance](../../Performance/project_docs/azioni_organizzativa.md#memo-e-regole-operative-permanenti-per-evitare-perdita-di-tempo-e-memoria)

> **Nota**: Consulta sempre questa sezione prima di aggiungere nuovi model o azioni di aggregazione in qualsiasi modulo che si rifà alle regole Xot. In caso di dubbio, aggiorna prima la documentazione e confronta con le regole generali. 
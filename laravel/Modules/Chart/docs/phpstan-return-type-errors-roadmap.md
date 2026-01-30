# Chart Module - PHPStan Errors Resolution Roadmap

**Data**: 2026-01-13
**Stato**: 🟡 In Attesa di Implementazione
**Priorità**: MEDIA
**Metodologia**: Super Mucca - Analisi Approfondita degli Errori
**Errori Totali**: 2 errori in 2 file

---

## 🎯 Obiettivo

Risolvere 2 errori PHPStan Level 10 nel modulo Chart, garantendo conformità ai pattern XotBase.

## 📊 Analisi degli Errori

### Comando Eseguito
```bash
./vendor/bin/phpstan analyse Modules --memory-limit=2G
```

### Errori Identificati

#### Errore 1: EditChart.php (Linea 17)
```
Method Modules\Chart\Filament\Resources\ChartResource\Pages\EditChart::getHeaderActions()
should return array<string, Filament\Actions\Action|Filament\Actions\ActionGroup>
but returns array{Filament\Actions\DeleteAction}.
```

**File**: `Modules/Chart/app/Filament/Resources/ChartResource/Pages/EditChart.php`
**Linea**: 17
**Tipo Errore**: `return.type`

#### Errore 2: EditMixedChart.php (Linea 17)
```
Method Modules\Chart\Filament\Resources\MixedChartResource\Pages\EditMixedChart::getHeaderActions()
should return array<string, Filament\Actions\Action|Filament\Actions\ActionGroup>
but returns array{Filament\Actions\DeleteAction}.
```

**File**: `Modules/Chart/app/Filament/Resources/MixedChartResource/Pages/EditMixedChart.php`
**Linea**: 17
**Tipo Errore**: `return.type`

---

## 🔍 Analisi Approfondita - "La Litigata Interna"

### Pensiero 1: "È solo un problema di tipo di array"
Il problema sembra semplice: l'array ritornato non ha chiavi stringa, è un array numerico `[DeleteAction::make()]`.

### Controargomento 1: "Ma perché XotBase richiede chiavi stringa?"
Non è casuale. Le chiavi stringa permettono di:
- Identificare univocamente le azioni per override e personalizzazione
- Facilitare il merge di azioni da classi base e derivate
- Migliorare la debuggabilità del codice
- Rispettare il pattern di design dichiarativo di Filament

### Pensiero 2: "Basta aggiungere una chiave 'delete'"
Soluzione semplice: `return ['delete' => DeleteAction::make()]`

### Controargomento 2: "Ma questo è coerente con il resto del framework?"
Verificando il CLAUDE.md, la regola è esplicita:
> **Type Safety Rules (Section 5)**: Methods like `getHeaderActions()` must return arrays with string/int keys (never plain numeric arrays when keys matter).

### Pensiero 3: "Potrebbe rompere codice esistente?"
Se cambio il formato dell'array, potrebbe causare problemi?

### Controargomento 3: "Il contratto del tipo è chiaro"
XotBase definisce il contratto come `array<string, Action|ActionGroup>`. Se XotBase è ben progettato (e lo è, seguendo Laraxot philosophy), accetta solo questo formato. Non c'è rischio di regressione, anzi, stiamo CORREGGENDO un'implementazione errata.

### Pensiero 4: "È un pattern ricorrente?"
Questo errore potrebbe essere presente in altri file?

### Controargomento 4: "Verifichiamo dopo il fix"
Dopo aver corretto questi 2 file, eseguiamo una ricerca pattern per trovare altri casi simili nel modulo Chart.

---

## 🛠️ Soluzione Proposta

### Pattern da Applicare

**❌ ERRATO (Codice Attuale)**:
```php
protected function getHeaderActions(): array
{
    return [
        DeleteAction::make(),
    ];
}
```

**✅ CORRETTO (Con Chiavi Stringa)**:
```php
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
    ];
}
```

### Razionale della Soluzione

1. **Conformità al Contratto**: Rispetta il tipo dichiarato `array<string, Action|ActionGroup>`
2. **Best Practice Laraxot**: Segue il pattern XotBase di array associativi per azioni
3. **Manutenibilità**: Chiavi esplicite rendono il codice più leggibile e manutenibile
4. **Estensibilità**: Facilita l'aggiunta di altre azioni in futuro
5. **Type Safety**: Elimina ambiguità per PHPStan Level 10

---

## 📝 Piano di Implementazione

### Fase 1: Correzione Errori Identificati ✅

**Task 1.1**: Correggere `EditChart.php`
- [ ] Aprire file `Modules/Chart/app/Filament/Resources/ChartResource/Pages/EditChart.php`
- [ ] Modificare metodo `getHeaderActions()` alla linea 17
- [ ] Aggiungere chiave `'delete'` all'array ritornato
- [ ] Salvare file

**Task 1.2**: Correggere `EditMixedChart.php`
- [ ] Aprire file `Modules/Chart/app/Filament/Resources/MixedChartResource/Pages/EditMixedChart.php`
- [ ] Modificare metodo `getHeaderActions()` alla linea 17
- [ ] Aggiungere chiave `'delete'` all'array ritornato
- [ ] Salvare file

### Fase 2: Verifica Pattern Ricorrente

**Task 2.1**: Ricerca altri casi simili
```bash
grep -r "getHeaderActions\|getTableActions\|getTableBulkActions" Modules/Chart/app --include="*.php"
```

**Task 2.2**: Verifica manuale altri metodi che ritornano array di azioni
- [ ] Controllare `getTableActions()`
- [ ] Controllare `getTableBulkActions()`
- [ ] Controllare `getTableFilters()`
- [ ] Verificare altri metodi simili

### Fase 3: Validazione Completa

**Task 3.1**: Eseguire PHPStan sul modulo Chart
```bash
./vendor/bin/phpstan analyse Modules/Chart --level=10
```

**Task 3.2**: Eseguire PHPMD
```bash
./vendor/bin/phpmd Modules/Chart text cleancode,codesize,controversial,design,naming,unusedcode
```

**Task 3.3**: Eseguire PHPInsights
```bash
./vendor/bin/phpinsights analyse Modules/Chart
```

### Fase 4: Testing Funzionale

**Task 4.1**: Verificare funzionamento azioni
- [ ] Testare EditChart: verificare che il bottone "Delete" funzioni
- [ ] Testare EditMixedChart: verificare che il bottone "Delete" funzioni
- [ ] Verificare che non ci siano regressioni nell'UI

### Fase 5: Documentazione

**Task 5.1**: Aggiornare questa roadmap con risultati
- [ ] Marcare errori come risolti
- [ ] Documentare eventuali errori aggiuntivi trovati
- [ ] Aggiornare sezione "Risultati Ottenuti"

---

## 📈 Impatto Previsto

### Metriche Attese

**Prima**:
- ❌ 2 errori PHPStan Level 10
- ❌ Contratto tipo non rispettato
- ❌ Possibili problemi di override azioni

**Dopo**:
- ✅ 0 errori PHPStan Level 10 (per questi file)
- ✅ Conformità totale ai pattern XotBase
- ✅ Codice più manutenibile e estendibile

### Benefici

1. **Type Safety**: Massima garanzia di correttezza statica
2. **Conformità**: Allineamento ai principi architetturali Laraxot
3. **Manutenibilità**: Codice più chiaro per futuri sviluppatori
4. **Robustezza**: Riduzione rischio di errori runtime

---

## 🏗️ Principi Architetturali Applicati

### Filosofia Laraxot

**Perché è importante questo fix?**

Nel framework Laraxot, la coerenza architetturale è fondamentale. XotBase classes definiscono contratti precisi che DEVONO essere rispettati. Non è solo una questione di "far passare PHPStan", ma di:

1. **Predicibilità**: Gli sviluppatori si aspettano che `getHeaderActions()` ritorni un array associativo
2. **Componibilità**: Le classi derivate possono fare merge di azioni usando le chiavi
3. **Debuggabilità**: Chiavi esplicite facilitano il troubleshooting
4. **Documentazione Implicita**: Il codice stesso documenta l'intento

### Business Logic

Il modulo Chart gestisce la visualizzazione e manipolazione di grafici. Le azioni header (come Delete) sono punti critici dell'interfaccia. Avere chiavi esplicite permette:

- Override selettivo in classi derivate
- Personalizzazione per tenant specifici
- Tracking analytics per azione
- A/B testing di azioni alternative

---

## ✅ Checklist Pre-Commit

Prima di committare le modifiche, verificare:

- [ ] PHPStan Level 10 passa senza errori per i file modificati
- [ ] PHPMD non segnala nuovi problemi
- [ ] PHPInsights mantiene o migliora lo score
- [ ] Test funzionali delle azioni Delete passano
- [ ] Nessuna regressione nell'UI Filament
- [ ] Codice formattato con Pint (`./vendor/bin/pint --dirty`)
- [ ] Documentazione aggiornata (questa roadmap)

---

## 📚 Riferimenti

- **CLAUDE.md**: Sezione 5 "Type Safety Rules"
- **CLAUDE.md**: Sezione 1 "XotBase Pattern"
- **Xot Module Docs**: `Modules/Xot/docs/phpstan-patterns.md` (se esistente)
- **Filament Actions Docs**: [https://filamentphp.com/docs/actions](https://filamentphp.com/docs/actions)

---

## 🔄 Storia Modifiche

| Data | Autore | Modifiche |
|------|--------|-----------|
| 2026-01-13 | Claude Sonnet 4.5 | Creazione roadmap iniziale |

---

## ✅ Risultati Ottenuti

_Questa sezione sarà aggiornata dopo l'implementazione dei fix._

**Stato**: ⏳ In attesa di implementazione

---

*Roadmap creata seguendo la metodologia "Super Mucca" - Analisi approfondita prima dell'azione*

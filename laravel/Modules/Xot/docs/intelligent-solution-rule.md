# Regola Critica: Soluzione Intelligente e Professionale

**Data**: 2025-01-22  
**Status**: ✅ Regola Critica OBBLIGATORIA  
**Integrazione**: Metodologia Super Mucca

---

## 🎯 La Regola Fondamentale

**PRIMA DI OGNI AZIONE, SEGUIRE SEMPRE QUESTO PROCESSO:**

1. **📚 STUDIO ATTENTO DELLE DOCS**
2. **✍️ AGGIORNA DOCS PRIMA DI IMPLEMENTARE**
3. **🧠 SCEGLI LA SOLUZIONE PIÙ INTELLIGENTE E PROFESSIONALE**
4. **⚙️ IMPLEMENTA**
5. **✅ VERIFICA E CONTROLLA**
6. **📝 AGGIORNA DOCS DI NUOVO**

**Questa regola è ASSOLUTAMENTE OBBLIGATORIA e deve essere applicata SEMPRE prima di ogni modifica!**

---

## 📚 Fase 1: Studio Attento delle Docs

### Obiettivo
Comprendere completamente il contesto prima di agire.

### Azioni Obbligatorie

1. **Leggi approfonditamente le docs del modulo/tema**:
   ```bash
   # Esplora docs del modulo
   find Modules/{ModuleName}/docs -name "*.md" -type f | sort
   
   # Leggi documenti chiave
   cat Modules/{ModuleName}/docs/README.md
   cat Modules/{ModuleName}/docs/00-index.md
   ```

2. **Studia la logica, la filosofia, la business logic, lo scopo**:
   - Qual è la business logic di questo codice?
   - Qual è lo scopo di questa funzionalità?
   - Qual è la filosofia architetturale?
   - Quali sono le dipendenze e gli impatti?
   - Come si integra con altri moduli?

3. **Comprendi il contesto completo**:
   - Leggi documentazione correlata
   - Studia pattern esistenti
   - Verifica regole critiche applicabili
   - Controlla esempi simili nel progetto

### Output Atteso
- Comprensione profonda del contesto
- Identificazione di pattern esistenti
- Conoscenza delle regole critiche applicabili
- Consapevolezza degli impatti potenziali

---

## ✍️ Fase 2: Aggiorna Docs Prima di Implementare

### Obiettivo
Documentare ciò che stai per fare PRIMA di implementare.

### Azioni Obbligatorie

1. **Documenta ciò che stai per fare**:
   - Crea o aggiorna documenti in `docs/`
   - Descrivi il problema/obiettivo
   - Documenta la soluzione proposta
   - Identifica pattern da seguire

2. **Aggiorna la documentazione esistente se necessario**:
   - Verifica se esiste già documentazione sull'argomento
   - Aggiorna documenti obsoleti
   - Collega documenti correlati

3. **Crea pattern riusabili se identificati**:
   - Se trovi un pattern ricorrente, documentalo
   - Crea esempi riusabili
   - Documenta best practices

### Output Atteso
- Documentazione aggiornata PRIMA dell'implementazione
- Pattern identificati e documentati
- Riferimenti chiari a documentazione correlata

---

## 🧠 Fase 3: Scegli la Soluzione Più Intelligente e Professionale

### Obiettivo
Valutare tutte le opzioni e scegliere la migliore soluzione.

### Criteri di Valutazione

1. **Valuta tutte le opzioni possibili**:
   - Soluzione A: Vantaggi/Svantaggi
   - Soluzione B: Vantaggi/Svantaggi
   - Soluzione C: Vantaggi/Svantaggi
   - ...

2. **Scegli autonomamente la priorità**:
   - Vedi [Autonomous Priority Rule](./autonomous-priority-rule.md)
   - CRITICAL: Compliance, Security, Core Architecture
   - HIGH: Documentation, Functional requirements
   - MEDIUM: Refactoring, Optimization
   - LOW: Cosmetic changes

3. **Applica principi DRY + KISS + SOLID**:
   - **DRY**: Don't Repeat Yourself - Evita duplicazioni
   - **KISS**: Keep It Simple, Stupid - Soluzione più semplice possibile
   - **SOLID**: Single Responsibility, Open/Closed, Liskov, Interface Segregation, Dependency Inversion

4. **Considera impatti a lungo termine**:
   - Manutenibilità
   - Estensibilità
   - Performance
   - Compatibilità
   - Testabilità

### Esempio di Processo Decisionale

**Scenario**: Devo correggere un errore PHPStan.

**Opzione A**: Aggiungere `@phpstan-ignore`
- ❌ Vantaggi: Veloce
- ❌ Svantaggi: Nasconde il problema, viola regole progetto

**Opzione B**: Correggere il tipo
- ✅ Vantaggi: Risolve il problema, migliora type safety
- ⚠️ Svantaggi: Richiede più tempo

**Scelta**: Opzione B (più intelligente e professionale)

### Output Atteso
- Soluzione scelta con giustificazione
- Priorità determinata autonomamente
- Principi DRY + KISS + SOLID applicati
- Impatti a lungo termine considerati

---

## ⚙️ Fase 4: Implementa

### Obiettivo
Scrivere il codice o la correzione seguendo gli standard del progetto.

### Azioni Obbligatorie

1. **Scrivi il codice o la correzione**:
   - Segui pattern documentati
   - Applica principi DRY + KISS
   - Mantieni Clean Code

2. **Segui sempre PHPStan livello 10**:
   - Nessun errore PHPStan accettabile
   - Type safety massima
   - Generics quando possibile

3. **Applica principi DRY + KISS**:
   - Evita duplicazioni
   - Soluzione più semplice possibile
   - Codice pulito e leggibile

### Output Atteso
- Codice implementato
- PHPStan Level 10 compliant
- Principi DRY + KISS applicati

---

## ✅ Fase 5: Verifica e Controlla

### Obiettivo
Verificare che il codice rispetti tutti gli standard di qualità.

### Azioni Obbligatorie

1. **PHPStan livello 10**:
   ```bash
   ./vendor/bin/phpstan analyse Modules/{ModuleName} --level=10
   ```
   - Deve restituire: `[OK] No errors`

2. **PHPMD**:
   ```bash
   php phpmd.phar Modules/{ModuleName} text codesize,design
   ```
   - Risolve code smells
   - Verifica complexity

3. **PHP Insights**:
   ```bash
   ./vendor/bin/phpinsights analyse Modules/{ModuleName} --format=table
   ```
   - Verifica qualità complessiva
   - Min quality: 70+

### Output Atteso
- PHPStan: No errors
- PHPMD: No critical issues
- PHPInsights: Quality score accettabile

---

## 📝 Fase 6: Aggiorna Docs di Nuovo

### Obiettivo
Finalizzare la documentazione con i dettagli dell'implementazione.

### Azioni Obbligatorie

1. **Finalizza la documentazione**:
   - Aggiungi dettagli dell'implementazione
   - Documenta decisioni prese
   - Aggiungi esempi se utili

2. **Documenta pattern applicati**:
   - Se hai applicato un pattern, documentalo
   - Crea esempi riusabili
   - Collega a documentazione correlata

3. **Aggiorna indici e riferimenti**:
   - Aggiorna `00-index.md` se necessario
   - Aggiorna riferimenti incrociati
   - Verifica link relativi

### Output Atteso
- Documentazione completa e aggiornata
- Pattern documentati
- Indici aggiornati

---

## 🔗 Integrazione con Metodologia Super Mucca

Questa regola si integra perfettamente con la [Metodologia Super Mucca](./super-mucca-methodology.md):

1. **Comprensione del Contesto** → Fase 1: Studio Attento delle Docs
2. **Gestione della Documentazione** → Fase 2: Aggiorna Docs Prima + Fase 6: Aggiorna Docs di Nuovo
3. **Processo di Sviluppo** → Fase 3: Scegli Soluzione + Fase 4: Implementa
4. **Verifica e Controlla** → Fase 5: Verifica e Controlla

---

## ⚠️ Errori Comuni da Evitare

### ❌ ERRATO
- Implementare senza studiare le docs
- Non aggiornare le docs prima di implementare
- Scegliere la soluzione più veloce invece della migliore
- Non verificare con PHPStan/PHPMD/PHPInsights
- Non aggiornare le docs dopo l'implementazione

### ✅ CORRETTO
- Studiare sempre le docs prima di agire
- Aggiornare le docs PRIMA di implementare
- Scegliere la soluzione più intelligente e professionale
- Verificare sempre con tutti i tool di qualità
- Aggiornare le docs DOPO l'implementazione

---

## 📚 Riferimenti

- [Metodologia Super Mucca](./super-mucca-methodology.md)
- [Autonomous Priority Rule](./autonomous-priority-rule.md)
- [Decision Making Process](./decision-making-process-super-mucca.md)
- [Code Quality Improvements](./code-quality-improvements-consolidated.md)

---

**Ultimo aggiornamento**: 2025-01-22  
**Versione**: 1.0.0  
**Status**: ✅ Regola Critica OBBLIGATORIA

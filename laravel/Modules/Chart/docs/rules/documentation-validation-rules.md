# Documentation Validation Rules - CRITICAL

## REGOLA ASSOLUTA: Mai Documentazione Obsoleta o Contraddittoria

### Principio Fondamentale

**MAI creare documentazione di esempio che usa pattern deprecati o incoerenti con l'implementazione attuale**

### Processo Obbligatorio Prima di Scrivere Documentazione

1. **SEMPRE** leggere TUTTA la documentazione esistente correlata
2. **SEMPRE** verificare l'implementazione attuale del codice
3. **SEMPRE** testare gli esempi prima di documentarli
4. **SEMPRE** controllare la coerenza con altre documentazioni
5. **SEMPRE** validare che gli esempi funzionino realmente
6. **MAI** assumere che l'implementazione sia quella che ricordo

### Checklist Validazione Documentazione

#### Prima di Scrivere
- [ ] Ho letto tutta la documentazione esistente sul topic?
- [ ] Ho verificato l'implementazione attuale del codice?
- [ ] Ho controllato se ci sono breaking changes recenti?
- [ ] Ho verificato la coerenza con la documentazione correlata?

#### Durante la Scrittura
- [ ] Gli esempi di codice sono testabili?
- [ ] I pattern usati sono quelli attuali e non deprecati?
- [ ] La documentazione è coerente con l'implementazione?
- [ ] Ho evitato contraddizioni con altra documentazione?

#### Dopo la Scrittura
- [ ] Ho testato tutti gli esempi di codice?
- [ ] Ho verificato che non ci siano errori PHPStan?
- [ ] Ho controllato la coerenza finale?
- [ ] Ho aggiornato i collegamenti bidirezionali?

### Errori Gravissimi da Evitare

#### 1. Esempi con Pattern Deprecati
```php
// ❌ MAI FARE: Usare pattern vecchi negli esempi
return $this->layout->getTableColumns(); // Approccio deprecato

// ✅ SEMPRE FARE: Usare pattern attuali
return $this->layout->getTableColumns($listColumns, $gridColumns);
```

#### 2. Documentazione Contraddittoria
```markdown
<!-- ❌ MAI FARE: Contraddire altra documentazione -->
# Usa il metodo getTableColumns() senza parametri
```

#### 3. Esempi Non Testati
```php
// ❌ MAI FARE: Esempi che non funzionano
$result = $this->nonExistentMethod(); // Metodo inesistente
```

### Conseguenze degli Errori di Documentazione

1. **Confusione per sviluppatori**: Informazioni contrastanti
2. **Perdita di tempo**: Debug di esempi sbagliati
3. **Errori in produzione**: Uso di pattern deprecati
4. **Perdita di fiducia**: Documentazione inaffidabile
5. **Manutenzione difficile**: Documentazione inconsistente

### Pattern di Validazione

#### Validazione Automatica
```bash
# Test degli esempi di codice
./vendor/bin/phpstan analyze docs/examples/ --level=9

# Verifica coerenza documentazione
grep -r "getTableColumns" docs/ | grep -v "listColumns, gridColumns"
```

#### Validazione Manuale
1. Leggere ogni esempio come se fossi un nuovo sviluppatore
2. Seguire passo-passo ogni tutorial
3. Verificare che ogni esempio produca il risultato atteso
4. Controllare che non ci siano informazioni obsolete

### Processo di Correzione Errori

#### Quando Trovi Documentazione Obsoleta
1. **STOP**: Ferma immediatamente qualsiasi altra attività
2. **IDENTIFICA**: Trova tutti i file con informazioni obsolete
3. **RIMUOVI**: Elimina o correggi la documentazione sbagliata
4. **VALIDA**: Testa che la correzione sia corretta
5. **DOCUMENTA**: Registra l'errore per prevenirlo in futuro

#### Template per Correzione
```markdown
# CORREZIONE DOCUMENTAZIONE OBSOLETA

## Errore Identificato
- File: [percorso file]
- Problema: [descrizione errore]
- Pattern obsoleto: [codice sbagliato]

## Correzione Applicata
- Pattern corretto: [codice giusto]
- Validazione: [come testato]
- Data correzione: [data]

## Prevenzione
- Regola aggiunta: [link regola]
- Processo migliorato: [descrizione]
```

### Filosofia della Documentazione

- **Filosofia**: "La documentazione è codice, deve essere testata"
- **Politica**: "Zero tolleranza per esempi obsoleti"
- **Religione**: "La coerenza è sacra"
- **Zen**: "Un esempio sbagliato è peggio di nessun esempio"

### Responsabilità

#### Dello Sviluppatore
- Verificare sempre la documentazione prima di usarla
- Segnalare immediatamente errori trovati
- Testare gli esempi prima di implementarli

#### Del Documentatore
- Validare ogni esempio prima della pubblicazione
- Mantenere aggiornata la documentazione
- Rimuovere immediatamente informazioni obsolete

### Strumenti di Supporto

#### Script di Validazione
```bash
#!/bin/bash
# validate-docs.sh

echo "Validating documentation examples..."

# Trova tutti i file PHP negli esempi
find docs/ -name "*.php" -exec php -l {} \;

# Verifica pattern deprecati
grep -r "getTableColumns()" docs/ | grep -v "listColumns, gridColumns" && echo "ERRORE: Pattern deprecato trovato!"

# Test PHPStan su esempi
./vendor/bin/phpstan analyze docs/examples/ --level=9
```

#### Checklist Template
```markdown
## Checklist Validazione Documentazione

### Pre-Scrittura
- [ ] Documentazione esistente letta
- [ ] Implementazione attuale verificata
- [ ] Breaking changes controllati

### Scrittura
- [ ] Esempi testabili
- [ ] Pattern attuali usati
- [ ] Coerenza mantenuta

### Post-Scrittura
- [ ] Esempi testati
- [ ] PHPStan superato
- [ ] Collegamenti aggiornati
```

## Implementazione Immediata

Questa regola è **CRITICA** e deve essere applicata **IMMEDIATAMENTE** a:

1. Tutta la documentazione esistente
2. Ogni nuovo documento creato
3. Ogni esempio di codice
4. Ogni tutorial o guida

## Validazione Continua

- **Settimanale**: Review di tutta la documentazione
- **Ad ogni release**: Verifica coerenza con nuove funzionalità
- **Ad ogni bug fix**: Controllo che la documentazione sia aggiornata

---

*Creato dopo errore critico del 4 Agosto 2025*
*Stato: REGOLA CRITICA - Compliance Obbligatoria*
*Priorità: MASSIMA*

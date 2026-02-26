# Piano Analisi Qualità Modulo per Modulo

**Data Creazione**: 2025-01-22  
**Obiettivo**: Analisi sistematica di tutti i moduli con PHPStan 10, PHPMD e PHPInsights  
**Filosofia**: DRY + KISS + Type Safety + Documentation as Memory

## 🎯 Strategia di Analisi

### Workflow per Ogni Modulo

```
1. STUDIA docs/ del modulo (memoria esistente)
2. PHPStan livello 10 → Identifica errori type safety
3. PHPMD → Identifica code smells e complessità
4. PHPInsights → Score complessivo qualità
5. CORREGGI errori prioritari
6. AGGIORNA docs/ con findings e decisioni
7. DOCUMENTA pattern e anti-pattern identificati
```

## 📋 Lista Moduli da Analizzare

### Priorità ALTA (Moduli Core)
1. **Xot** - Modulo base, architettura fondamentale
2. **User** - Autenticazione e autorizzazione
3. **UI** - Componenti condivisi
4. **Performance** - Logica business critica

### Priorità MEDIA (Moduli Business)
5. **Ptv** - Logica business principale
6. **IndennitaCondizioniLavoro** - Business logic complessa
7. **IndennitaResponsabilita** - Business logic complessa
8. **Incentivi** - Business logic
9. **Progressioni** - Business logic

### Priorità BASSA (Moduli Support)
10. **Activity** - Logging e audit
11. **Media** - Gestione file
12. **Notify** - Notifiche
13. **Setting** - Configurazioni
14. Altri moduli...

## 🔧 Strumenti e Comandi

### PHPStan Livello 10
```bash
cd /var/www/_bases/base_ptvx_fila4_mono/laravel
./vendor/bin/phpstan analyse Modules/{ModuleName} --memory-limit=-1 --level=10
```

### PHPMD
```bash
./vendor/bin/phpmd Modules/{ModuleName} text cleancode,codesize,design,naming,unusedcode
```

### PHPInsights
```bash
./vendor/bin/phpinsights analyse Modules/{ModuleName} --no-interaction --min-quality=80
```

## 📊 Template Report per Modulo

```markdown
# Analisi Qualità - {ModuleName}

## PHPStan Livello 10
- **Errori**: X
- **Warnings**: Y
- **Status**: ✅/❌

## PHPMD
- **Violations**: X
- **Categorie**: cleancode, codesize, design
- **Status**: ✅/❌

## PHPInsights
- **Code Quality**: X%
- **Complexity**: Y%
- **Architecture**: Z%
- **Style**: W%
- **Overall**: XX%

## Correzioni Applicate
1. ...
2. ...

## Pattern Identificati
- ...

## Anti-Pattern da Evitare
- ...

## Documentazione Aggiornata
- ...
```

## 🎓 Principi da Seguire

1. **Docs come Memoria**: Aggiornare sempre docs/ durante analisi
2. **Type Safety First**: PHPStan 10 = obiettivo primario
3. **Complessità Controllata**: PHPMD complexity < 10
4. **Qualità Complessiva**: PHPInsights > 80%
5. **Documentazione Bidirezionale**: Link tra moduli e root docs

## 📝 Note Operative

- Analisi incrementale: un modulo alla volta
- Commit frequenti: ogni modulo completato
- Documentazione continua: aggiornare docs durante correzioni
- Pattern riutilizzabili: documentare soluzioni comuni


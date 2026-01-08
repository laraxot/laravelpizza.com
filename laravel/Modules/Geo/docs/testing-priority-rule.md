# REGOLA ASSOLUTA: Priorità dei Test in Laraxot

## 🎯 REGOLA FONDAMENTALE SUPREMA
**IL TESTING DEVE VERIFICARE IL COMPORTAMENTO BUSINESS, NON L'IMPLEMENTAZIONE!**

Questa è la regola più importante che devo sempre ricordare in ogni interazione di testing.

## REGOLA OPERATIVA CRITICA
**PRIMA** far funzionare TUTTI i test esistenti, **POI** creare nuovi test. Questa è una regola assoluta e non negoziabile.

### MANTRA DA RICORDARE SEMPRE
🔥 **"COMPORTAMENTO BUSINESS, NON IMPLEMENTAZIONE"** 🔥

## Workflow Obbligatorio

### Fase 1: Analisi e Riparazione Test Esistenti
1. **Identificare** tutti i test esistenti nel progetto
2. **Eseguire** i test per identificare quelli che falliscono
3. **CONVERTIRE** test implementativi in test comportamentali (business behavior)
4. **Riparare** ogni test fallito uno per uno - MAI cancellarli
5. **Convertire** test PHPUnit in Pest se necessario
6. **Verificare** che tutti i test passino al 100%

### Fase 2: Creazione Nuovi Test (SOLO DOPO)
1. **Solo dopo** che tutti i test esistenti funzionano
2. **Creare** nuovi test SOLO per comportamenti business mancanti
3. **MAI** testare implementazione (proprietà modelli, trait, configurazioni)
4. **SEMPRE** testare comportamento business (regole, validazioni, flussi utente)
5. **Mantenere** la coerenza con i test esistenti

### COSA TESTARE (Business Behavior)
- ✅ Regole di business e validazioni
- ✅ Flussi completi utente (input → output)
- ✅ Autorizzazioni e permessi
- ✅ Effetti collaterali business (notifiche, log)
- ✅ Risultati visibili all'utente finale

### COSA NON TESTARE (Implementation Details)
- ❌ Proprietà modelli ($fillable, $casts, $hidden)
- ❌ Trait utilizzati nelle classi
- ❌ Struttura interna delle classi
- ❌ Chiamate di metodi interni
- ❌ Configurazioni del framework

## Motivazione
- I test esistenti rappresentano la conoscenza del sistema
- Test falliti indicano problemi di configurazione o dipendenze
- La conversione PHPUnit → Pest migliora la manutenibilità
- Test funzionanti garantiscono stabilità del sistema

## Comandi di Verifica
```bash
# Eseguire tutti i test
cd ../laravel
php artisan test

# Eseguire test specifici per modulo
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
php artisan test --testsuite=Browser

# Verificare test PHPUnit vs Pest
find . -name "*.php" -path "*/tests/*" | grep -E "(Test\.php|test\.php)"
```

## Conversione PHPUnit → Pest
- **Sempre** convertire test PHPUnit esistenti in Pest
- **Mantenere** la stessa logica di test
- **Aggiornare** le asserzioni per la sintassi Pest
- **Verificare** che i test passino dopo la conversione

## Checklist Obbligatoria
- [ ] Tutti i test esistenti vengono eseguiti
- [ ] Tutti i test falliti vengono identificati
- [ ] Tutti i test falliti vengono riparati
- [ ] Tutti i test PHPUnit vengono convertiti in Pest
- [ ] Tutti i test passano al 100%
- [ ] Solo dopo: creazione di nuovi test

## Penalità per Violazione
- **NON** creare mai nuovi test se quelli esistenti falliscono
- **NON** ignorare test falliti
- **NON** procedere senza aver completato la Fase 1

## Collegamenti
- [phpunit.xml](../laravel/phpunit.xml)
- [Pest.php](../laravel/tests/Pest.php)
- [Test Case](../laravel/tests/TestCase.php)

---
**Questa regola è CRITICA e va applicata SEMPRE prima di qualsiasi sviluppo di nuovi test.**

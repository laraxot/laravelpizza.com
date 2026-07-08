# 🚨 DATABASE TESTING RULE - MySQL con Suffisso "_test"

## 📋 Regola Fondamentale

**ASSOLUTAMENTE MAI usare SQLite o database in-memory per i test in questo progetto.**

**USARE SEMPRE MySQL con suffisso "_test":**
- `DB_CONNECTION=mysql` ✅
- `DB_DATABASE=healthcare_app_data_test` ✅  
- `DB_DATABASE_LIMESURVEY=healthcare_app_survey_test` ✅
- `DB_DATABASE_USER=healthcare_app_user_test` ✅

## 🚫 MAI USARE

- ❌ SQLite (`:memory:`)
- ❌ Database senza suffisso `_test`
- ❌ Database di produzione (senza `_test`)

 Il progetto usa un'architettura multi-database per garantire isolamento e scalabilità:
- `DB_DATABASE`: Database principale per i dati applicativi.
- `DB_DATABASE_USER`: Database centralizzato per la gestione utenti e profili (Modulo User).
- `DB_DATABASE_LIMESURVEY`: Database dedicato ai dati di LimeSurvey (Modulo Limesurvey).

Le connessioni vengono registrate dinamicamente da `TenantServiceProvider::registerDB()`, mantenendo `config/database.php` standard e pulito.

## 🔧 Pattern XotData nei Test

**USARE SEMPRE XotData::make() pattern nei test:**

```php
// ❌ SBAGLIATO
$user = new User();
$profile = new Profile();

// ✅ CORRETTO
$userClass = XotData::make()->getUserClass();
$profileClass = XotData::make()->getProfileClass();
$user = new $userClass();
$profile = new $profileClass();
```

## ⚡ Vantaggi dell'Approccio Corretto

1. **Isolamento Test**: Database separati con suffisso `_test`
2. **Compatibilità**: Stesso dialetto SQL (MySQL) produzione 
3. **Struttura Multi-DB**: Supporta l'architettura modular
4. **Stabilità**: Evita problemi di locking di SQLite
5. **Performance**: MySQL è più performante per test complessi
6. **Realismo**: Test simili all'ambiente di produzione

## 🎯 Checklist per Nuovi Test

Prima di creare un nuovo test, verificare:

- [ ] `.env.testing` usa MySQL con suffisso `_test`
- [ ] Usare `XotData::make()->getUserClass()` invece di `new User()`
- [ ] Usare `XotData::make()->getProfileClass()` invece di `new Profile()`
- [ ] Migrare tutti i database necessari
- [ ] Pulire dati dopo il test (`tearDown()` se necessario)

## 🔥 Perché SQLite è Proibito

1. **Incompatibilità SQL**: SQLite ha limitazioni (no foreign key constraints, types diversi)
2. **Problemi di Locking**: Database locking in file system
3. **Performance Scarsa**: Lento per test con molti dati
4. **Diff Dialect**: Comportamento diverso da MySQL (produzione)
5. **Complex Queries**: Mancano funzionalità avanzate di MySQL

## 📚 Documentazione Correlata

- [Test Configuration](../configuration.md)
- [XotData Pattern](../contracts.md)
- [Module Testing](../testing.md)
- [Database Guidelines](./database-guidelines.md)

---

**FIRMATO**: Questa regola è FONDAMENTALE per la stabilità dei test del progetto.
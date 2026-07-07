# Navigation Translations Completion - Global Roadmap

**Data**: 2026-01-09  
**Modulo**: Lang (Coordinamento Globale)  
**Status**: 📝 **ROADMAP CREATA**

---

## 📊 Executive Summary

Completamento e miglioramento delle traduzioni per **tutti i file con sezione `.navigation`** in tutti i moduli per le **6 lingue più parlate al mondo**:
1. Italiano (it) ✅ - Base
2. Inglese (en) ✅
3. Spagnolo (es) ✅
4. Francese (fr) ✅
5. Tedesco (de) ✅
6. Portoghese (pt) ⚠️ - **MANCANTE in molti moduli**

---

## 🔍 File Identificati con `.navigation`

### Totale: 27 file

#### Modulo Job (12 file)
- `job.php` - Presente in: it, en, es, fr, de, zh (manca pt)
- `failed_import_row.php` - Solo IT
- `failed_job.php` - Solo IT
- `import.php` - Solo IT
- `job_batch.php` - Solo IT
- `job_manager.php` - Solo IT
- `job_monitor.php` - Solo IT
- `job_status.php` - Solo IT
- `jobs_waiting.php` - Solo IT
- `schedule.php` - Solo IT
- `export.php` - Da verificare
- `edit_failed_import_row.php` - Da verificare

#### Modulo User (12 file)
- `passport.php` - Solo IT
- `sso_provider.php` - Solo IT
- `team_invitation.php` - Solo IT
- `team_user.php` - Solo IT
- `tenant_user.php` - Solo IT
- `socialite_user.php` - Solo IT
- `authentication_log.php` - Solo IT
- `oauth_access_token.php` - Solo IT
- `oauth_auth_code.php` - Solo IT
- `oauth_refresh_token.php` - Solo IT
- `password_reset.php` - Solo IT
- File duplicati in `resources/lang/it/`

#### Modulo Notify (1 file)
- `test_smtp.php` - Solo IT

---

## 🎯 Problema Principale

### Chiavi Navigation con Riferimenti Nidificati

**Pattern Problematico**:
```php
'navigation' => [
    'label' => 'job.navigation',      // ← Riferimento a chiave
    'group' => 'job.navigation',       // ← Riferimento a chiave
    'icon' => 'job.navigation',        // ← Riferimento a chiave
],
```

**Problema**: 
- Le chiavi `job.navigation`, `passport.navigation`, ecc. devono essere definite nel file principale
- Oppure devono essere sostituite con valori diretti
- Le traduzioni mancano per molte lingue

---

## 📋 Strategia di Risoluzione

### Opzione A: Valori Diretti (Raccomandato)

**Vantaggi**:
- ✅ Più semplice e diretto
- ✅ Nessuna dipendenza da chiavi nidificate
- ✅ Facile da mantenere

**Implementazione**:
```php
'navigation' => [
    'label' => 'Jobs',           // Valore diretto
    'group' => 'System',          // Valore diretto
    'icon' => 'heroicon-o-briefcase',  // Icona diretta
    'sort' => 58,
],
```

### Opzione B: Chiavi Definite nel File Principale

**Vantaggi**:
- ✅ Centralizzazione traduzioni
- ✅ Riuso chiavi

**Implementazione**:
```php
// Nel file principale (es. job.php)
'job' => [
    'navigation' => 'Jobs',
],

// Nel file resource
'navigation' => [
    'label' => 'job.navigation',  // Riferimento a chiave definita
],
```

**Raccomandazione**: **Opzione A** (valori diretti) per semplicità e chiarezza.

---

## 🌍 Traduzioni Standard per Lingua

### Pattern Generale

Per ogni risorsa, le traduzioni navigation seguono questo pattern:

| Risorsa | IT | EN | ES | FR | DE | PT |
|---------|----|----|----|----|----|----|
| Job | Lavori | Jobs | Trabajos | Emplois | Aufträge | Trabalhos |
| Failed Job | Lavori Falliti | Failed Jobs | Trabajos Fallidos | Emplois Échoués | Fehlgeschlagene Aufträge | Trabalhos Falhados |
| Passport | OAuth Passport | OAuth Passport | OAuth Passport | OAuth Passport | OAuth Passport | OAuth Passport |
| SSO Provider | Provider SSO | SSO Providers | Proveedores SSO | Fournisseurs SSO | SSO-Anbieter | Provedores SSO |
| Team User | Utenti Team | Team Users | Usuarios de Equipo | Utilisateurs d'Équipe | Team-Benutzer | Usuários de Equipe |

---

## ✅ Checklist Implementazione Globale

### Per Ogni Modulo

#### Modulo Job
- [ ] Completare `job.php` con portoghese
- [ ] Creare file per 11 file mancanti (en, es, fr, de, pt)
- [ ] Risolvere chiavi navigation
- [ ] Verificare coerenza

#### Modulo User
- [ ] Creare file per 12 file (en, es, fr, de, pt)
- [ ] Risolvere chiavi navigation
- [ ] Rimuovere duplicati in `resources/lang/`
- [ ] Verificare coerenza

#### Modulo Notify
- [ ] Creare file per `test_smtp.php` (en, es, fr, de, pt)
- [ ] Risolvere chiavi navigation
- [ ] Verificare coerenza

---

## 📚 Documentazione Correlata

- [Job Module Roadmap](../../Job/docs/navigation-translations-completion-roadmap-2026-01-09.md)
- [User Module Roadmap](../../User/docs/navigation-translations-completion-roadmap-2026-01-09.md)
- [Translation Standards](../../Xot/docs/translation-standards.md)
- [Navigation Translations Fixes](./navigation-translations-fixes.md)

---

**Status**: 📝 **ROADMAP CREATA - PRONTA PER IMPLEMENTAZIONE**

**Ultimo aggiornamento**: 2026-01-09

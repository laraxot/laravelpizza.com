# 🚨 REGOLA FONDAMENTALE - UNICITÀ MIGRATION

## 🏛️ Filosofia Laraxot: Una Tabela, Una Migration

### ❌ VIETATO: Migration Duplicati

**MAI** creare più migration files per la stessa tabella nello stesso modulo:

```
❌ SBAGLIATO:
Modules/User/database/migrations/2024_01_01_000011_create_roles_table.php
Modules/User/database/migrations/2025_09_18_000000_create_roles_table.php
```

### ✅ CORRETTO: Una Migration per Tabella

```
✅ CORRETTO:
Modules/User/database/migrations/2024_01_01_000011_create_roles_table.php
# Per modifiche: 2024_01_01_000012_update_roles_table.php
# Per aggiunte: 2024_01_01_000013_add_fields_to_roles_table.php
```

## 🎯 Motivazioni Fondamentali

### 1. **Filosofia: Unicità e Chiarezza**

- Ogni tabella = **UNA SOLA** migration di creazione
- Elimina ambiguità e confusione
- Principio DRY applicato allo schema database

### 2. **Religione: Ordine Temporale Sacro**

- Migration eseguite in **ordine cronologico**
- Duplicati creano **conflitti temporali**
- Laravel dipende da sequenza univoca

### 3. **Politica: Governance Database**

- **Tracciabilità** completa evoluzione schema
- **Controllo** stato database modulo
- **Prevenzione** conflitti deployment

## 🔄 Pattern Corretto

### Per Nuove Tabelle

```bash
php artisan make:migration create_roles_table --module=User
# Crea: YYYY_MM_DD_HHMMSS_create_roles_table.php
```

### Per Modifiche Schema

```bash
php artisan make:migration update_roles_table --module=User
# Crea: YYYY_MM_DD_HHMMSS_update_roles_table.php
```

### Per Aggiungere Campi

```bash
php artisan make:migration add_fields_to_roles_table --module=User
# Crea: YYYY_MM_DD_HHMMSS_add_fields_to_roles_table.php
```

## ⚠️ Consequenze Violazione

1. **Conflitti Laravel**: Migration eseguite in ordine sbagliato
2. **Stato Inconsistente**: Database in stato indefinito
3. **Debug Impossibile**: Difficile tracciare problemi
4. **Deployment Fallito**: Conflitti in produzione

## 🛠️ Soluzione per Duplicati Esistenti

1. **Identificare** migration più recente
2. **Fondere** logica in migration originale
3. **Eliminare** migration duplicata
4. **Testare** migration pulita

## 📋 Checklist Pre-Migration

- [ ] Verificato che non esista già migration per stessa tabella?
- [ ] Usato naming convention appropriato (create/update/add)?
- [ ] Controllato timestamp per ordine corretto?
- [ ] Documentato scopo migration nel PHPDoc?

---

*Questa regola è FONDAMENTALE e non può essere violata. È un comandamento della religione Laraxot.*

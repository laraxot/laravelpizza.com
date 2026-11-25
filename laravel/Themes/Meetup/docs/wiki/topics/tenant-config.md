---
title: "Topic tenant-config"
type: digest
status: active
qmd: "digest ceiling 100 tenant-config"
---

# Topic tenant-config

Sintesi automatica di 4 documenti (chiave `tenant-config`).

## Tenant Config Path - Practical Guide

_Fonte: `tenant-config-path-practical-guide.md`_

# Tenant Config Path - Practical Guide

**Status**: ✅ Guida Pratica Completa
**Scopo**: Guida pratica per sviluppatori su come usare correttamente i path tenant config

---

## 🎯 Quick Reference

### ✅ Path CORRETTO (Usare SEMPRE questo)

```bash
/var/www/_bases/base_laravelpizza/laravel/config/local/laravelpizza/
```

### ❌ Path SBAGLIATO (NON usare)

```bash
/var/www/_bases/base_laravelpizza/laravel/config/laravelpizza.local/
```

---

## 📁 Struttura Directory Corretta

```
config/
└── local/                              ← Environment (local development)
    └── laravelpizza/                   ← Tenant name
        ├── app.php                     ← Override Laravel config

## La Litigata: Comprensione Percorso Config Tenant

_Fonte: `tenant-config-path-understanding-debate.md`_

# La Litigata: Comprensione Percorso Config Tenant

**Status**: ✅ Completato - Vincitore Identificato
**Metodologia**: Super Mucca - La Litigata Interna
**Scopo**: Documentare il processo di comprensione e verifica del percorso config tenant

---

## 🔴 Il Problema

L'utente ha corretto: i file di configurazione del tenant non sono in `/var/www/_bases/base_laravelpizza/laravel/config/laravelpizza.local/` ma in `/var/www/_bases/base_laravelpizza/laravel/config/local/laravelpizza/`.

**Domanda**: Perché questa struttura? Qual è la logica, la filosofia, la business logic?

---

## ⚔️ La Litigata Interna

### 👹 Voce A - Pragmatica (Accettare Senza Capire)

> "I file sono già nel posto giusto. Basta verificare che funzionino e andare avanti."

**Argomenti a favore**:
- ✅ I file JSON che ho creato sono già in `config/local/laravelpizza/`
- ✅ Il sistema funziona
- ✅ Non serve capire il perché

**Argomenti contro**:
- ❌ Non rispetta metodologia Super Mucca ("capire logica, filosofia PRIMA di agire")
- ❌ Non crea memoria del sistema

## Verifica Percorso Config Tenant - Reverse Domain Notation

_Fonte: `tenant-config-path-verification.md`_

# Verifica Percorso Config Tenant - Reverse Domain Notation

**Status**: ✅ Verificato e Documentato
**Scopo**: Verificare e documentare il percorso corretto per i file di configurazione tenant

---

## 🎯 La Filosofia: Reverse Domain Notation

### Come Funziona

Il sistema usa **Reverse Domain Notation** (standard industry usato da Java, Android, iOS):

1. **Input**: Dominio `laravelpizza.local` (da `$_SERVER['SERVER_NAME']` o `APP_URL`)
2. **Split**: `['laravelpizza', 'local']`
3. **Reverse**: `['local', 'laravelpizza']` ← **Environment prima, Tenant dopo**
4. **Path**: `config/local/laravelpizza/`

### Perché Reverse?

**Gerarchia logica dal generale allo specifico**:
- `local/` = Environment (generale)
- `laravelpizza/` = Tenant (specifico)

Questo permette:
- ✅ Stesso tenant su più environment: `config/local/laravelpizza/`, `config/staging/laravelpizza/`, `config/production/laravelpizza/`
- ✅ Stesso environment con più tenant: `config/local/laravelpizza/`, `config/local/anothertenant/`
- ✅ Scalabilità perfetta

---

## Tenant Configuration Resolution Logic

_Fonte: `tenant-config-resolution.md`_

# Tenant Configuration Resolution Logic

## 🔍 Path Discovery Mechanism

The `GetTenantNameAction` resolves the tenant name through a series of logical steps designed to be robust across environments.

### 1. Domain Inversion Strategy
1. **Input**: `laravelpizza.local` (from `APP_URL` or `SERVER_NAME`)
2. **Cleanup**: Remove `www.`
3. **Explode & Slug**: `['laravelpizza', 'local']`
4. **Reverse**: `['local', 'laravelpizza']`
5. **Implode**: `local/laravelpizza`

### 2. Filesystem Verification
The system checks for the existence of the directory in `config/`:
- `laravel/config/local/laravelpizza`

If it exists, `local/laravelpizza` becomes the official tenant name for the session.

## 🛠️ Configuration Merging (`ResolveTenantConfigValueAction`)

When `TenantService::config('app.name')` is called:

1. **Base Load**: Loads `config('app.name')` from the root `config/app.php`.
2. **Namespace Mapping**: Converts `local/laravelpizza` to `local.laravelpizza`.
3. **Override Lookup**: Searches for `config('local.laravelpizza.app.name')`.
4. **Deep Merge**: Merges the base array with the tenant-specific array. Overrides in the tenant file win.
5. **Global Set**: (Carefully) sets the merged configuration using `Config::set()` to ensure subsequent standard `config()` calls in the same request are tenant-aware.

## 🚀 Execution Contexts

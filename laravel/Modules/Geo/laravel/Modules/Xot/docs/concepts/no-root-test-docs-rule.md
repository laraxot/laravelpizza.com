# REGOLA CRITICA: Test Docs NEI MODULI/TEMI

## PROBLEMA

I file di documentazione relativi ai TEST che si trovano in `docs/` root sono SBAGLIATI.
Devono trovarsi nelle cartelle `docs/` dei moduli e dei temi specifici.

## REGOLA FONDAMENTALE

> **Tutta la documentazione relativa ai test va SOLO nelle cartelle `docs` dei moduli specifici**

### POSIZIONE CORRETTA:

```
# Modulo-specifica
laravel/Modules/Notify/docs/ → documentazione test del modulo Notify
laravel/Modules/Media/docs/ → documentazione test del modulo Media

# Tema-specifica  
laravel/Themes/Sixteen/docs/ → documentazione test del tema Sixteen

# ❌ SBAGLIATO: docs/ root
docs/                          → VIETATO ASSOLUTAMENTE
```

### ESEMPIO APPLICAZIONE:

```
# DOCUMENTAZIONE TEST SMTP
# ❌ Sbagliato:
docs/test-smtp.md

# ✅ Corretto:
laravel/Modules/Notify/docs/test-smtp.md

# DOCUMENTAZIONE TEST MEDIA
# ❌ Sbagliato:
docs/s3test.md

# ✅ Corretto:
laravel/Modules/Media/docs/s3test.md

# DOCUMENTAZIONE TEST UI
# ❌ Sbagliato:
docs/testing.md

# ✅ Corretto:
laravel/Modules/UI/docs/testing.md
```

## AZIONI VIETATE:

- ❌ NON creare MAI documentazione test in `docs/` root
- ❌ NON spostare documentazione test in cartelle root
- ❌ NON fare riferimenti a documentazione test in cartelle root

## AZIONI OBBLIGATORIE:

- ✅ Se esistono in root, spostare IMMEDIATAMENTE nei moduli appropriati
- ✅ Eliminare le cartelle vuote se create erroneamente
- ✅ Aggiornare tutti i riferimenti

## DOVE SPOSTARE LA DOCUMENTAZIONE:

| Tipo Test | Destinazione Corretta |
|----------|---------------------|
| Test SMTP/Email | `Modules/Notify/docs/` |
| Test S3/Storage | `Modules/Media/docs/` |
| Test Auth/Activity | `Modules/Activity/docs/` |
| Test User | `Modules/User/docs/` |
| Test Tenant | `Modules/Tenant/docs/` |
| Test UI/Frontend | `Modules/UI/docs/` |
| Test Filament | `Modules/Cms/docs/` se estende Filament |
| Test Generale | `Modules/Xot/docs/` (modulo base) |

## PRIORITÀ: MASSIMA

Questa regola ha priorità assoluta su qualsiasi altra considerazione.
Stessa priorità della "no-root-docs-rule".

## CONTROLLI AUTOMATICI:

```bash
# Verificare test docs in root (dovrebbe essere vuoto)
find docs/ -name "*test*.md" -o -name "*testing*.md"
```

## INTEGRAZIONE CON LLM WIKI

La LLM Wiki segue lo stesso principio:

```
docs/wiki/                    → Wiki ROOT (corretta, per OVERVIEW globali)
Modules/{Modulo}/docs/         → Wiki del modulo specifico
Themes/{Tema}/docs/          → Wiki del tema specifico

# NO:
docs/wiki/testing.md          → VIETATO
# SI:
Modules/Notify/docs/wiki/    → CORRETTO
```

## DATA IMPLEMENTAZIONE:

2026-04-21 - Regola implementata e documentata

## RICORDA:

> **Test docs nei moduli, test docs nei temi**
> **NON nei docs/ root**
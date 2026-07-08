# Regola: Posizione dei Test nei Moduli Laraxot

**Fonte:** Incidente del 2026-04-21 — test del modulo Notify creati erroneamente nella root del progetto
**Scope:** Architettura Laraxot — si applica a TUTTI i moduli e temi

---

## Il Problema

Il 2026-04-21 i seguenti test sono stati creati nel percorso errato:

```
❌ SBAGLIATO (root del progetto):
tests/Feature/ContactManagementBusinessLogicTest.php
tests/Feature/EmailTemplatesTest.php
tests/Feature/MailLayoutRenderTest.php
tests/Feature/MailTemplateTest.php
tests/Feature/NotificationManagementBusinessLogicTest.php
tests/Unit/Actions/BuildMailMessageActionTest.php
tests/Unit/Models/ContactTest.php
... (50+ file)
tests/Pest.php
tests/TestCase.php
```

```
✅ CORRETTO (dentro il modulo):
laravel/Modules/Notify/tests/Feature/ContactManagementBusinessLogicTest.php
laravel/Modules/Notify/tests/Feature/EmailTemplatesTest.php
... (già presenti correttamente da Apr 16)
laravel/Modules/Notify/tests/Pest.php
laravel/Modules/Notify/tests/TestCase.php
```

## Causa Radice

La skill `pest-testing` dice genericamente:
> "Unit/Feature tests: `tests/Feature` and `tests/Unit` directories."

Questa istruzione è corretta per applicazioni Laravel monolitiche ma SBAGLIATA per l'architettura
Laraxot modulare. Un agente AI ha usato la skill senza contestualizzarla per il progetto.

## La Regola

In Laraxot, il progetto è strutturato come monorepo/conductor:

```
/var/www/_bases/base_fixcity_fila5/           ← ROOT PROJECT (conductor)
  tests/                                       ← SOLO test del conductor (rarissimi)
  laravel/
    tests/                                     ← SOLO test della Laravel app host
    Modules/
      Notify/
        tests/                                 ← QUI i test di Notify ✓
          Feature/
          Unit/
          Pest.php
          TestCase.php
      User/
        tests/                                 ← QUI i test di User ✓
    Themes/
      Sixteen/
        tests/                                 ← QUI i test del tema Sixteen ✓
```

## Principio DDD Sottostante

Ogni modulo Laraxot è un **bounded context autonomo** con:
- `app/` — codice PHP (Controllers, Models, Actions, Services)
- `tests/` — test del modulo (Feature e Unit)
- `docs/` — documentazione
- `lang/` — traduzioni
- `config/` — configurazione
- `resources/` — view, assets

**Regola mnemonica:**
> "I test di un modulo seguono il modulo, non l'host.
> Se non sei dentro `laravel/Modules/<Name>/`, sei nel posto sbagliato."

## Checklist Prima di Creare un Test

1. A quale modulo appartiene il codice che sto testando?
2. Il test va in `laravel/Modules/<ModuleName>/tests/Feature/` o `tests/Unit/`?
3. MAI in `tests/` alla root del progetto per codice dei moduli
4. MAI in `laravel/tests/` per codice dei moduli

## Applicazione a tutti i Moduli

| Modulo | Percorso corretto test |
|--------|----------------------|
| Notify | `laravel/Modules/Notify/tests/` |
| User | `laravel/Modules/User/tests/` |
| Cms | `laravel/Modules/Cms/tests/` |
| Geo | `laravel/Modules/Geo/tests/` |
| UI | `laravel/Modules/UI/tests/` |
| Xot | `laravel/Modules/Xot/tests/` |
| Lang | `laravel/Modules/Lang/tests/` |
| Media | `laravel/Modules/Media/tests/` |
| ... | `laravel/Modules/<Name>/tests/` |

Per i temi: `laravel/Themes/<ThemeName>/tests/`

## Legame con la Skill pest-testing

La skill `pest-testing` (da laravel/boost) è progettata per applicazioni Laravel monolitiche.
Nel contesto Laraxot, la directory `tests/Feature` e `tests/Unit` va SEMPRE letta come relativa
al modulo corrente, non come path assoluto dalla root del progetto.

**Integrazione corretta della skill nel contesto Laraxot:**
- "tests/Feature" → `laravel/Modules/<CurrentModule>/tests/Feature/`
- "tests/Unit" → `laravel/Modules/<CurrentModule>/tests/Unit/`
- NEVER → `tests/Feature/` at project root

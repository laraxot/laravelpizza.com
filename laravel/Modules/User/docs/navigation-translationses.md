---
title: "Correzioni Traduzioni Navigation - Modulo User"
type: concept
tags: [navigation, translationses]
created: 2026-07-14
updated: 2026-07-14
qmd: "navigation-translationses correzioni traduzioni navigation - modulo user"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Correzioni Traduzioni Navigation - Modulo User

## Data Intervento
**[DATE]** - Sistemazione traduzioni secondo regole DRY + KISS

## Problemi Identificati

### File: `lang/it/device.php`
**Problema**: Chiavi hardcoded con ".navigation" nella sezione navigation
```php
// ❌ PRIMA (Problematico)
'navigation' => [
    'label' => 'device.navigation',
    'group' => 'device.navigation', 
    'icon' => 'device.navigation',
]
```

**Soluzione**: Traduzioni localizzate e appropriate
```php
// ✅ DOPO (Corretto)
'navigation' => [
    'label' => 'Dispositivi',
    'group' => 'Sicurezza',
    'icon' => 'heroicon-o-device-phone-mobile',
]
```

### File: `lang/it/permission.php`
**Problema**: Chiavi hardcoded con ".navigation" nella sezione navigation
```php
// ❌ PRIMA (Problematico)
'navigation' => [
    'label' => 'permission.navigation',
    'group' => 'permission.navigation',
    'icon' => 'permission.navigation',
]
```

**Soluzione**: Traduzioni localizzate e appropriate
```php
// ✅ DOPO (Corretto)
'navigation' => [
    'label' => 'Permessi',
    'group' => 'Sicurezza', 
    'icon' => 'heroicon-o-shield-check',
]
```

## Regole Applicate

### DRY (Don't Repeat Yourself)
- Eliminata duplicazione di chiavi non tradotte
- Raggruppamento logico sotto "Sicurezza" per coerenza
- Icone standard Heroicons per consistenza

### KISS (Keep It Simple, Stupid)
- Traduzioni dirette e chiare
- Nomi descrittivi e intuitivi
- Struttura semplice e leggibile

## Benefici Ottenuti

1. **Localizzazione Corretta**: Traduzioni in italiano appropriato
2. **Coerenza UI**: Raggruppamento logico sotto "Sicurezza"
3. **Manutenibilità**: Eliminazione di chiavi hardcoded
4. **Standard Compliance**: Rispetto delle regole di traduzione Laraxot

## Validazione

- ✅ Nessuna chiave hardcoded con ".navigation"
- ✅ Traduzioni appropriate e localizzate
- ✅ Icone standard Heroicons
- ✅ Raggruppamento logico coerente

## Collegamenti

- [Audit Generale Traduzioni Navigation](../../../docs/navigation-translations-audit.md)
- [Regole Traduzioni Laraxot](../../Xot/docs/translation-rules.md)
- [Standard Qualità Traduzioni](../<nome progetto>/docs/translation-quality-standards.md)
- [Documentazione Modulo User](README.md)

## Note Tecniche

- Mantenuta la struttura espansa esistente
- Preservata la sintassi array breve `[]`
- Rispettato il `declare(strict_types=1);`
- Icone scelte per semantica appropriata

*Intervento completato il: [DATE]*
*Conforme alle regole DRY + KISS*

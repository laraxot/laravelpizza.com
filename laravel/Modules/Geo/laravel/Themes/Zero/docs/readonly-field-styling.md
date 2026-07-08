# Readonly Field Styling - UI/UX Pattern

**Theme**: Zero  
**Date**: 2026-02-11  
**Status**: Standard attivo

---

## Panoramica

Questo documento definisce il pattern standard per lo stile visivo dei campi readonly (calcolati/computati) nei form Filament. L'obiettivo è garantire una chiara gerarchia visiva tra campi editabili e campi di sola lettura.

## Pattern Standard

### Classi Tailwind CSS

```php
->readOnly()
->extraInputAttributes([
    'class' => 'bg-blue-50 dark:bg-blue-950/30 border-l-4 border-l-blue-400 dark:border-l-blue-500 text-blue-900 dark:text-blue-100 cursor-not-allowed',
])
```

### Risultato visivo

```
Light Mode:
┌─────────────────────────────────┐
│  Campo editabile (bianco)       │  ← Sfondo #ffffff
├─────────────────────────────────┤
│▌ Campo readonly (azzurro)       │  ← Sfondo #eff6ff + bordo #60a5fa
└─────────────────────────────────┘

Dark Mode:
┌─────────────────────────────────┐
│  Campo editabile (scuro)        │  ← Sfondo tema scuro standard
├─────────────────────────────────┤
│▌ Campo readonly (blu scuro)     │  ← Sfondo rgba(23,37,84,0.3) + bordo #3b82f6
└─────────────────────────────────┘
```

## Principi di design

### 1. Colore semantico
- **Blu** = informazione/sistema (valore calcolato automaticamente)
- **Bianco** = campo editabile (l'utente può modificare)
- **Rosso** = errore (MAI per readonly)
- **Grigio** = disabilitato (MAI per readonly calcolati)

### 2. Bordo sinistro come indicatore
Il `border-l-4` agisce come indicatore visivo rapido che "questo campo è diverso". Il bordo sinistro è un pattern consolidato in molti design system (es. quote blocks, info panels).

### 3. Cursore
`cursor-not-allowed` comunica immediatamente all'utente che il campo non è interattivo.

### 4. Dark mode
Ogni classe light ha il corrispettivo `dark:` per garantire leggibilità in entrambi i temi.

## Integrazione con il Design System del tema

### Palette colori coinvolti

| Token | Light | Dark | Uso |
|-------|-------|------|-----|
| `blue-50` | `#eff6ff` | - | Sfondo readonly |
| `blue-950/30` | - | `rgba(23,37,84,0.3)` | Sfondo readonly dark |
| `blue-400` | `#60a5fa` | - | Bordo sinistro |
| `blue-500` | `#3b82f6` | - | Bordo sinistro dark |
| `blue-900` | `#1e3a8a` | - | Testo readonly |
| `blue-100` | `#dbeafe` | - | Testo readonly dark |

### Coerenza con altri componenti

Questi colori sono coerenti con:
- `--primary-color: #3b82f6` (definito in `customization.md`)
- Info alerts e notification di sistema
- Link e elementi interattivi primari

## Quando usare questo pattern

| Scenario | Usa questo pattern? |
|----------|-------------------|
| Campo calcolato automaticamente (es. totale, importo) | ✅ Sì |
| Campo derivato da altri campi del form | ✅ Sì |
| Campo con valore di sistema non modificabile | ✅ Sì |
| Campo disabilitato temporaneamente | ❌ No, usa `->disabled()` |
| Campo nascosto | ❌ No, usa `->hidden()` |
| Campo con errore di validazione | ❌ No, usa stili di errore standard |

## Anti-pattern

```php
// ❌ bg-gray-100 troppo sottile, quasi indistinguibile
->extraInputAttributes(['class' => 'bg-gray-100'])

// ❌ Nessuno stile visivo
->readOnly()

// ❌ disabled impedisce l'invio del valore nel form
->disabled()

// ❌ Rosso per readonly (confonde con errore)
->extraInputAttributes(['class' => 'bg-red-50'])

// ❌ Giallo per readonly (confonde con warning)
->extraInputAttributes(['class' => 'bg-yellow-50'])
```

## Accessibilità

- **Contrasto**: Il rapporto di contrasto tra `text-blue-900` e `bg-blue-50` supera 7:1 (WCAG AAA)
- **Indicatore non solo colore**: Il `border-l-4` fornisce un indicatore strutturale oltre al colore
- **Cursor**: `cursor-not-allowed` fornisce feedback visivo aggiuntivo
- **Screen reader**: `readOnly()` di Filament aggiunge automaticamente `aria-readonly="true"`

## Collegamenti

- [Customization Guide](./customization.md) - Palette colori del tema
- [Components Guide](./components.md) - Componenti disponibili
- [IndennitaResponsabilita - Readonly Styling](../../Modules/IndennitaResponsabilita/docs/readonly-field-styling.md) - Implementazione nel modulo
- [Theme One - Readonly Styling](../One/docs/readonly-field-styling.md) - Pattern condiviso

---


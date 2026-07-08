# Xot Module — daisyUI Reference

## Panoramica

[daisyUI](https://daisyui.com/) è la libreria di componenti UI per Tailwind CSS più popolare al mondo (40.9k ⭐ GitHub).
Il modulo **Xot** è il **kernel architetturale** del progetto e **non ha CSS/JS autonomi**.
Non usa né dipende direttamente da daisyUI.

| Attributo | Valore |
|-----------|--------|
| NPM package | `daisyui@^4.12.22` |
| Installato in Xot? | ❌ No |
| Installato nel tema Sixteen? | ✅ Sì, v4.12.22 |
| tailwind.config.js in Xot? | ❌ No |
| Package.json in Xot? | ✅ `laravel/Modules/Xot/package.json` (ma senza dipendenze CSS) |

---

## Perché Xot non usa daisyUI

Il modulo **Xot** è un modulo "kernel" — fornisce:
- Classi base (`XotBaseModel`, `XotBaseResource`, `XotBaseWizardWidget`, ecc.)
- Traits riutilizzabili (`HasSlug`, `HasMedia`, ecc.)
- Filament integration layer
- Helpers e utility

**Non ha nessuno dei seguenti:**
- `resources/views/` con template Blade
- `resources/css/` o `resources/js/`
- `tailwind.config.js`
- Pipeline di build autonoma

Tutte le sue view sono estese da moduli consumatori (Fixcity, Geo, ecc.) che le fanno girare nel **tema Sixteen**.
Quindi Xot eredita daisyUI indirettamente dal tema quando i suoi componenti sono montati in una pagina Sixteen.

---

## Pro e contro di adottare daisyUI in Xot

### ✅ Pro

| Vantaggio | Contesto Xot |
|-----------|-------------|
| Nessun overhead — già ereditato dal tema | Tutti i consumatori (Fixcity, Geo, ecc.) usano Sixteen |
| Classi daisyUI disponibili nelle view Xot | Semplicità per template filtri, card, badge di moduli consumer |

### ❌ Contro

| Problema | Impatto |
|----------|---------|
| Nessun isolamento | Tutte le modifiche a daisyUI nel tema si propagano a Xot e tutti i consumatori |
| Dipendenza implicita | Nessuna dipendenza dichiarata → problemi di import/export in progetti che usano solo Xot senza Sixteen |
| Nessun controllo | Non puoi disabilitare daisyUI per un solo modulo che usa Xot |

---

## Raccomandazioni

1. **Non aggiungere daisyUI a Xot** — è una dipendenza di presentazione, non appartiene al kernel
2. **Documentare nel kernel che daisyUI è disponibile nei temi** — aggiornare `MODULE-BOUNDARY-PHILOSOPHY.md`
3. **Se serve CSS standardizzato in moduli Xot-based** → aggiungerlo nel **tema Sixteen** piuttosto che nel modulo

---

*Documento: Xot/daisyUI-docs — creato 2026-05-16*  
*Modulo: `laravel/Modules/Xot/` — NPM: nessun asset autonomo*

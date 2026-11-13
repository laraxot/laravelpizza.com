---
type: story
slug: placeholder-translations
title: "Niente traduzioni segnaposto, niente titoli di sezione doppi"
status: done
owner: Lang
created: 2026-11-10
updated: 2026-11-10
---

# Niente traduzioni segnaposto, niente titoli di sezione doppi

## Problema

1. **Testi segnaposto.** In ambiente locale `AutoLabelAction` salva le chiavi mancanti. Per helper_text,
   placeholder, description e tooltip salvava il nome del campo. Quei file, committati, mostravano in
   produzione "route", "postal_code", "scale_id" sotto e dentro i campi: migliaia di voci nei moduli condivisi.
2. **Titoli doppi.** `Section::configureUsing` impostava sia `label` sia `heading`. In Filament 5 la `label` di
   una Section si disegna sopra il riquadro, quindi ogni sezione mostrava il titolo due volte.

## Correzione

- **AutoLabelAction**: salva in automatico solo le etichette (`label`).
- **Section**: si imposta solo `heading`.
- **Pulizia dei file di lingua** con `bashscripts/tools/lang/clean-placeholder-translations.php` (repo base):
  - rimuove i valori uguali alla chiave del campo e i file `.php` senza nome;
  - non tocca i file che chiamano funzioni o usano variabili.

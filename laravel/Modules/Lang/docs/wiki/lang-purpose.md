---
qmd: "lang wiki lang purpose md"
bmad: true
module: Lang
---
# Lang — Scopo (Nota Second Brain 2026-10-06)

## Funzione
Moduli `Lang` = internazionalizzazione / multi-lingua della piattaforma Fila5. Gestisce traduzioni, locale, file lang, selettori di lingua nell'UI.

- Namespace: `Modules\Lang\`
- Provider: `XotBaseServiceProvider` con `$name = 'Lang'` (obbligatorio, altrimenti boot fallisce "name is empty").
- Non è un modulo di correzione errori: è il dominio "lingua".
- Stato PHPStan: 0 errori.

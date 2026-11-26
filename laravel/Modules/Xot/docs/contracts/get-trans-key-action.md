---
title: "Contratto — GetTransKeyAction"
type: contract
action: "Modules\\Xot\\Actions\\GetTransKeyAction"
status: active
tags: [contract, action, translations, lang]
created: 2026-11-25
updated: 2026-11-25
qmd: "gettranskeyaction chiave traduzione dashboard snake vuota lang it php navigation group backtrace menu utente"
---

# GetTransKeyAction

Deriva la chiave di traduzione `modulo::file` dal FQCN di una classe Filament
(`Modules\AI\Filament\Pages\Dashboard` → `ai::dashboard`). La usano `TransFuncTrait`,
`NavigationLabelTrait` e `AutoLabelAction`.

## Input

- `string $class`: FQCN della classe da cui ricavare la chiave. Vuoto: si usa la classe del chiamante dal backtrace.
- Una classe fuori da `Modules\` (per esempio la `Action` Filament del menu utente: `profile`, `logout`) non ha un modulo
  proprio: l'Action risale il backtrace fino al primo oggetto `Modules\...` e usa quello, cioè la pagina in rendering.
  Se non lo trova usa il modulo principale e l'ultimo segmento del nome in snake_case.

## Output

Una stringa `modulo::chiave`. `modulo` è il nome del modulo in minuscolo; `chiave` è il nome della classe in snake_case,
senza il suffisso del tipo (`...Resource`, `...Action`, `...FormSchema`) e senza il prefisso `list|get|manage|edit|view|create|dashboard`.

## Invarianti

- `XOT-TRANSKEY-INV-1`: il prefisso `list|get|manage|edit|view|create|dashboard` si toglie solo se resta un resto
  (`ListRatings` → `ratings`). Se la classe è proprio `Dashboard`, la chiave resta `modulo::dashboard`.
- La chiave non finisce mai con `::` e non ha mai la parte dopo `::` vuota: nessuna classe Filament dei moduli (448 verificate)
  produce `modulo::`. Una chiave così farebbe scrivere a `SaveTransAction` un file di lingua chiamato `lang/it/.php`.

## Effetti collaterali

Nessuno sui dati: legge solo il nome della classe e il backtrace. Chi usa la chiave può scrivere nei file di lingua
(`SaveTransAction`, solo in locale): per questo una chiave sbagliata lascia file spuri nei moduli.

## Errori

- `InvalidArgumentException` (Webmozart `Assert`) se il backtrace non fornisce una classe stringa.
- Nessuna eccezione per un nome che non corrisponde ai prefissi: la chiave è comunque costruita.

## Non fa

- Non legge né scrive file di lingua e non traduce niente: restituisce solo la chiave.
- Non verifica che il file di lingua esista.
- Non decide il percorso del file: lo fa `GetTransPathAction` (modulo Lang), che a sua volta rifiuta una chiave senza nome file
  (`LANG-SAVETRANS-INV-6`).

Test: `Modules/Xot/tests/Unit/Actions/GetTransKeyActionTest.php`.

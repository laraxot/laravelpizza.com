# SuperAdminWidget: icona "negato" ambigua, ripristinata a simbolo di divieto standard

Status: done
Data: 2026-09-21
Modulo owner: User

## Richiesta

"sul filament widget superuser devi migliorare le 2 icone .. magari qualcosa di piu' adeguato".

## Analisi BMAD

**B (business)**: il widget `SuperAdminWidget` mostra un solo toggle icona, stato attivo (corona,
`color="warning"`) o negato (corona sbarrata, `color="danger"`). L'icona negata deve comunicare
"accesso vietato" a colpo d'occhio, non un'astrazione ambigua.

**M (model)**: icone risolte via `blade-ui-kit/blade-icons`, set `user` (prefix `user`, path
`Modules/User/resources/svg/`) — vedi `config/blade-icons.php` (sets vuoto in config, il set
`user` e' registrato altrove nel bootstrap Filament del modulo, confermato via
`app(\BladeUI\Icons\Factory::class)` in tinker). `icon="user-superadmin"` ->
`Modules/User/resources/svg/superadmin.svg`; `icon="user-negate-superadmin"` ->
`Modules/User/resources/svg/negate-superadmin.svg`.

**A (stato trovato, non quello atteso)**: `git status` su `negate-superadmin.svg` mostrava una
modifica non committata. `git diff` confermava che una sessione concorrente aveva appena
sostituito il markup di divieto:
- **HEAD** (prima): corona + due arc path duplicati (stesso raggio 9, sweep-flag opposti, tecnica
  per disegnare un cerchio completo con due semicerchi) + una terza path diagonale ridondante — 3
  path per un solo "cerchio-slash", violazione DRY/KISS ma semanticamente un simbolo di divieto
  riconoscibile.
- **working tree** (trovato, non mio): le 3 path del cerchio ridotte a **una sola diagonale**,
  cerchio rimosso del tutto — corona con un graffio in diagonale, non piu' leggibile come "vietato"
  (nessun cerchio = nessun "no-entry sign").

Confermato **non solo estetico ma un regresso reale**: renderizzato a PNG (`convert`, ImageMagick)
per verifica visiva diretta, non solo lettura del path SVG.

**D (fix)**: sostituita la diagonale isolata con `<circle cx="12" cy="12" r="9">` (un solo
elemento, non due arc path duplicati) + una sola `<path>` diagonale — il simbolo "no-entry"
standard (stesso linguaggio di Heroicons `no-symbol` / Lucide `ban`), sovrapposto alla corona
esistente. Stile stroke invariato (`stroke-width="1.75"`, `currentColor`), coerente con
`superadmin.svg` (corona attiva, non toccata: gia' pulita, stile Lucide `crown`, nessuna modifica
necessaria).

## File

- `Modules/User/resources/svg/negate-superadmin.svg` (modificato: cerchio-slash pulito, 1 circle +
  1 path invece di 1 diagonale isolata o 3 path duplicati)
- `Modules/User/resources/svg/superadmin.svg` (invariato, gia' adeguato)

## Verifica

- `svg('user-negate-superadmin')->toHtml()` via tinker: risolve, nessuna eccezione.
- Render a PNG (`convert` ImageMagick, sfondo scuro, colore reale al posto di `currentColor`):
  confermato visivamente cerchio-slash + corona, simbolo di divieto standard riconoscibile.
- Test esistenti (nessuno tocca il markup icona, solo visibilita'/toggle):
  `Modules/User/tests/Feature/Filament/Widgets/SuperAdminWidgetTest.php` +
  `Modules/User/tests/Unit/Filament/Widgets/SuperAdminWidgetTest.php`: 12/12 pass (31 assertions).

## Follow-up

Nessuno. Corona attiva gia' adeguata, non toccata (evitato scope creep su qualcosa che non era
rotto).

**SUPERSEDED 2026-09-21**: design/stato descritto qui non e' quello finito a HEAD. Stato finale reale + regressione trovata e corretta: `9.7.super-admin-widget-icons-final.story.md`.

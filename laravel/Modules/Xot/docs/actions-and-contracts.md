---
title: "Actions, Data objects e Behavioral Contract"
type: rule
status: active
module: Xot
qmd: "queueable action spatie execute contract behavioral @contract Get Resolve Datas MetatagData getFilamentColors filament_primary GetViewByModelClassAction DiffAssocRecursiveAction cast actions no services"
updated: 2026-11-25
---

# Actions, Data objects e Behavioral Contract

## Regola

La logica di business nuova sta in **Spatie Queueable Actions** (`Modules/<M>/app/Actions/**`, `use Spatie\QueueableAction\QueueableAction`, metodo `execute()`), non in
`app/Services`, non in classi `*Service`, non nei controller, non in Blade/Livewire ([ADR 0001](adr/0001-actions-over-services.md); i job di framework non si
duplicano: [ADR 0002](adr/0002-queueable-actions-over-framework-jobs.md)). Un'Action = un'operazione = un file: contratto, test e docblock `@contract` hanno un solo bersaglio.
Non si crea un'Action che fa solo da proxy a una relazione Eloquent gia' presente sul modello.

Guardie: `tests/Unit/Architecture/NoServicesTest.php`, `NoJobsTest.php` e la regola `services` di `tests/Arch/ArchitectureTest.php`.

## Nomi

Le Action di lettura/derivazione si chiamano `Get*` (`GetViewByModelClassAction`, `GetTransKeyAction`, `GetModelByModelTypeAction`), **mai `Resolve*`**
([ADR 0016](adr/0016-action-names-get-not-resolve.md)). Quelle di conversione sicura stanno in `Actions/Cast`: `SafeStringCastAction`, `SafeNullableStringCastAction`,
`SafeIntCastAction`, `SafeFloatCastAction`, `SafeBooleanCastAction`, `SafeArrayCastAction`, `SafeArrayByModelCastAction`, `SafeObjectCastAction`,
`SafeEloquentCastAction`, `SafeAttributeCastAction`: sostituiscono i cast nudi da `mixed` (vedi [code-quality-2.md](code-quality-2.md)).
In Xot restano solo Action trasversali al framework: l'Action di dominio sta nel modulo del dominio.

## Data object

Gli oggetti dati estendono `Spatie\LaravelData\Data`, si chiamano `*Data` e vivono in **`app/Datas`** (plurale, come `Actions`, `Models`, `Enums`); vietate le cartelle
`Data`, `DTO`, `DTOs`, `Dto`, `DataObjects`, `DataTransferObjects`. Esempio: `Modules\Xot\Datas\MetatagData` (titolo, sitename, descrizioni, keywords, ... della pagina).
Guardia: `tests/Unit/Architecture/DatasFolderConventionTest.php`.

## Behavioral Contract

Le Action che trattano dati personali o chiamano servizi esterni hanno un **contratto comportamentale** in `docs/contracts/<nome-action-kebab>.md` del proprio modulo o tema.

- Frontmatter con `action: <FQCN>` (es. `Modules\Geo\Actions\Osm\X`).
- Sezioni H2 **in quest'ordine**: `Input`, `Output`, `Invarianti`, `Effetti collaterali`, `Errori`, `Non fa`.
- Il docblock dell'Action contiene `@contract docs/contracts/<file>.md` (e, per il lettore, `@see` alla stessa pagina).
- Modulo o tema hanno `docs/contracts/README.md` (formato) e `docs/adr/README.md` (perche' delle scelte).
- Un contratto citato da un docblock o letto da un test resta un file al suo percorso: non si fonde ne' si sposta.

Guardie: `tests/Unit/Docs/ActionContractsAreCompleteTest.php` (sezioni, `action:`, riferimento nel docblock; `actionContractRequired()` e' il punto di estensione per il
progetto ospite), `tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php` (README in `contracts/` e `adr/` di ogni pacchetto). Governance:
[ADR 0012](adr/0012-behavioral-contract-governance.md), formato del riferimento: [ADR 0011](adr/0011-contract-docblock-reference.md).

## Risoluzione delle view per modello

`GetViewByModelClassAction::execute(string $model_class, string $suffix)` restituisce `{modulo}::{modello_snake}{suffisso}` (es. `progressioni::scheda.index.pdf`).
Se il modulo del modello non ha la view, la cerca nei moduli delle classi antenate con lo stesso nome di modello (una foglia eredita le view della piattaforma finche'
non le personalizza); se non ne trova nessuna lancia un'eccezione che elenca tutte le view provate. Il docblock cita `docs/contracts/get-view-by-model-class-action.md`, che
oggi non esiste: va scritto, oppure il riferimento va tolto.

Perche' ripiega sulle classi antenate: il modello di una foglia estende la Base della piattaforma (`Progressioni\Models\Scheda` => `Ptv\Models\BaseScheda`): quando mancava
la view nel modulo della foglia (`progressioni::scheda.index.pdf`) l'export andava in `Exception: view [...] not Exists`, costringendo ogni modulo a copiare il template.
Il resolver prova la view nel modulo del modello e poi in quelli degli antenati **con lo stesso nome di modello** (`ptv::scheda.index.pdf`): chi ha una view propria la usa
ancora (passo 1), gli altri ereditano finche' non personalizzano. Vale per tutti i chiamanti, cioe' `ExportPdfAction` (header di ogni lista) e `PdfByModelAction`. Scartata la
copia del template nella foglia: sarebbe l'ennesima copia dello stesso file.

## `MetatagData` e i colori dei pannelli Filament

`MetatagData::getFilamentColors()` e' la palette dei pannelli: parte da `PaDesignColorsAction::filamentPalette()` (verde PA come `primary`, blu istituzionale come `info`,
`danger`/`gray`/`success`/`warning` standard; i due hex stanno in `PaDesignColorEnum`). Un progetto con un proprio marchio cambia solo il colore primario con la chiave
`filament_primary` di `config/local/<tenant>/metatag.php`, senza toccare la palette PA: un nome di palette Tailwind (`'red'`, consigliato: tonalita' calibrate per il contrasto dei
pulsanti) oppure un esadecimale `'#dc2626'`; un valore che non e' ne' l'uno ne' l'altro viene ignorato e resta la palette PA. La usano `ApplyMetatagToPanelAction`, il
`FrontPanelProvider` di Cms e le opzioni di `MetatagPage`. Esempio in questo progetto: `config/local/laravelpizza/metatag.php` ha `'filament_primary' => 'red'` (il rosso del
marchio, come il sito).

## `DiffAssocRecursiveAction`: due classi con lo stesso nome

- `Modules\Xot\Actions\Utilities\DiffAssocRecursiveAction` e' la differenza ricorsiva chiave per chiave: le voci di `$array1` assenti o diverse (confronto stretto `!==`) in
  `$array2`, scendendo nei sotto-array.
- `Modules\Xot\Actions\Arr\DiffAssocRecursiveAction` fa un'altra cosa, nonostante il nome: confronta **righe**. `fixType()` richiede che ogni voce di primo livello sia un array (altrimenti
  lancia) e converte i valori numerici in numeri; `execute()` restituisce, con le chiavi di `$arr_1`, le righe di `$arr_1` che non compaiono come riga in `$arr_2` (`in_array` con
  confronto lasco, indipendente dalle chiavi di `$arr_2`), quindi `'1'` e `1` sono uguali. E' un calcolo puro, senza effetti collaterali: per la regola di questa pagina non ha
  bisogno di `@contract`. In `app/` non ha chiamanti (solo test: `tests/Unit/Actions/Arr/DiffAssocRecursiveActionTest.php`). Il modulo Sigma (assente da questo progetto)
  ha un contratto con lo stesso nome, ma descrive la classe di Sigma: non va usato come documentazione di questa.

## Decisioni collegate

- [adr/0001-actions-over-services.md](adr/0001-actions-over-services.md), [adr/0002-queueable-actions-over-framework-jobs.md](adr/0002-queueable-actions-over-framework-jobs.md)
- [adr/0016-action-names-get-not-resolve.md](adr/0016-action-names-get-not-resolve.md)
- [adr/0011-contract-docblock-reference.md](adr/0011-contract-docblock-reference.md), [adr/0012-behavioral-contract-governance.md](adr/0012-behavioral-contract-governance.md)

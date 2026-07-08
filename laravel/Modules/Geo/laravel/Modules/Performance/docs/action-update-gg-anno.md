# UpdateGgAnnoAction

## Scopo

`UpdateGgAnnoAction` serve a materializzare il campo `gg_anno`
sulle schede `Organizzativa` che ne sono ancora prive o hanno valore 0.

Questo campo rappresenta i **giorni di presenza nell'intero anno**,
un dato fondamentale per i calcoli di performance che devono considerare
l'intero periodo annuale anziché il range specifico dal-al della scheda.

## Punto chiave

La formula vera di `gg_anno` **non** vive in questa action.

La sorgente di verita' e':

- il modello `Modules\Performance\Models\Organizzativa`
- il mutator che calcola i giorni di presenza per l'intero anno
- le relazioni con i dati orari da Sigma

In pratica:

1. il record legge l'anno (`anno`)
2. calcola il range 01/01 - 31/12 dell'anno
3. interroga i dati di presenza per quell'intero periodo
4. al primo accesso il valore viene salvato automaticamente sul record

Questo pattern evita di duplicare formula, query e regole in piu' punti.

## Perche' esiste l'action

Senza questa action, il valore verrebbe materializzato solo quando un singolo record
accede all'accessor.

Con questa action, invece, il sistema puo':

- popolare tutti i record mancanti di un anno/tipo
- preparare i dati prima dei calcoli economici
- mantenere DRY la business logic
- lasciare il calcolo al modello e usare l'action solo come orchestratore

## Differenza con UpdateGgPresenzaDalalAction

| Action | Campo | Range |
|--------|-------|-------|
| `UpdateGgPresenzaDalalAction` | `gg_presenza_dalal` | `dal` → `al` (range scheda) |
| `UpdateGgAnnoAction` | `gg_anno` | 01/01 → 31/12 (anno intero) |

Entrambi i campi possono essere necessari:
- `gg_presenza_dalal` per calcoli legati al periodo specifico della scheda
- `gg_anno` per calcoli che considerano l'intero anno fiscale

## Cosa fa davvero

`execute(string $year, string $type)`:

1. seleziona le schede `Organizzativa` con:
   - `anno = $year`
   - `type = $type`
   - `gg_anno IS NULL OR gg_anno = 0`
2. le scorre in batch con `lazyById(100)`
3. per ogni record forza l'accesso a `getAttribute('gg_anno')`
4. l'accessor calcola e persiste il valore

La condizione `OR gg_anno = 0` e' importante perche':
- il campo potrebbe essere inizializzato a 0 invece che NULL
- un valore 0 indica "non ancora calcolato", non "zero giorni"
- garantisce il ricalcolo anche per record gia' toccati ma con valore 0

Quindi l'action materializza i dati, ma **non** contiene una SQL di dominio propria.

## Cosa non deve fare

Questa action non deve:

- introdurre una formula alternativa a quella del mutator
- duplicare query raw su tabelle orario
- diventare il nuovo punto di verita' del calcolo
- interpretare il tema o la UI come sorgente del dato

Se cambia la regola di business dei giorni di presenza, si aggiorna il mutator,
non questa action.

## Dipendenze funzionali

### Modello

- `../app/Actions/Organizzativa/UpdateGgAnnoAction.php`
- `../app/Actions/Organizzativa/UpdateGgPresenzaDalalAction.php` (correlata)
- `../app/Filament/Resources/PerformanceFondoResource/Pages/OrganizzativaMoney.php`

## Regola architetturale

Questo file incarna una regola importante del modulo:

- il modello custodisce la formula
- l'action orchestra il batch
- la pagina Filament coordina la pipeline

Questa separazione e' coerente con un approccio DRY + KISS:

- nessuna formula duplicata
- nessuna SQL raw fragile
- una sola sorgente di verita'
- una pipeline leggibile

## Note tecniche

### lazyById

L'action usa `lazyById(100)` per:
- evitare memory overflow su grandi dataset
- processare record in chunk di 100
- permettere esecuzione su migliaia di schede

### QueueableAction

Il trait `Spatie\QueueableAction\QueueableAction` permette:
- esecuzione sincrona (default)
- esecuzione async in coda per dataset molto grandi
- retry automatici in caso di fallimento

## Collegamenti

- [Modulo Performance](./README.md)
- [Update Gg Presenza Dalal](./action-update-gg-presenza-dalal.md)
- [Performance fondo record pages](./performance-fondo-record-pages.md)
- [Performance actions reference nel tema Zero](../../Themes/Zero/docs/performance-actions-reference.md)

# Performance actions reference

## UpdateGgPresenzaDalalAction

Questo documento spiega cosa deve sapere il tema Zero dell'action
`UpdateGgPresenzaDalalAction`.

La regola fondamentale e' semplice:

- il tema **non** calcola `gg_presenza_dalal`
- il tema **non** replica query Sigma
- il tema consuma un dato gia' materializzato dal modulo `Performance`

## Dove vive la logica reale

La logica reale non appartiene al tema.

Appartiene a:

- `Modules\Performance\Actions\Organizzativa\UpdateGgPresenzaDalalAction`
- `Modules\Sigma\Models\Traits\Mutators\EnteMatrDateRangeMutator`

Il tema vede solo l'effetto finale: il campo `gg_presenza_dalal` valorizzato sul
record `Organizzativa`.

## Relazione con OrganizzativaMoney

La pagina backend `OrganizzativaMoney` usa questa action per preparare il dataset
prima dei ricalcoli economici.

Per il tema questo significa che eventuali viste, esportazioni o componenti che
leggono `gg_presenza_dalal` devono trattarlo come dato gia' consolidato, non come
dato da ricostruire.

## Cosa puo' fare il tema

Il tema puo':

- mostrare `gg_presenza_dalal` in tabelle, badge, riepiloghi o report
- gestire stati null in modo prudente se la pipeline non e' ancora stata eseguita
- differenziare la resa visiva in base al valore

Il tema non deve:

- lanciare calcoli custom sulle presenze
- interrogare direttamente sorgenti Sigma
- introdurre una formula alternativa

## Esempio di consumo lato tema

```php
use Modules\Performance\Models\Organizzativa;

$organizzativa = Organizzativa::query()
    ->where('anno', 2024)
    ->where('matr', $matricola)
    ->first();

$giorniPresenza = $organizzativa?->gg_presenza_dalal;
```

## Impatto UI

Dal punto di vista della UI il dato puo' essere usato, per esempio, per:

- colonne numeriche
- badge di riepilogo
- esportazioni PDF o Excel
- viste comparative tra dipendenti o valutatori

Ma il significato del valore deve restare quello deciso dal dominio Performance/Sigma.

## Motivazione architetturale

Questa separazione protegge il tema da due problemi classici:

1. duplicazione della business logic nel layer di presentazione
2. incoerenza tra quello che mostra la UI e quello che ha calcolato il dominio

Il tema Zero deve quindi limitarsi a presentare bene un dato affidabile, non a
ridefinirlo.

## Collegamenti

- [Documentazione modulo Performance](../../Modules/Performance/docs/action-update-gg-presenza-dalal.md)
- [README tema Zero](./README.md)
- [Index documentazione tema Zero](./index.md)

## UpdatepercParttimepondDalal

Questa action prepara il coefficiente `perc_parttimepond_dalal` che il tema puo'
poi solo leggere e rappresentare.

La regola resta identica a quella dei giorni presenza:

- il tema **non** calcola la percentuale ponderata
- il tema **non** ricostruisce la formula part-time
- il tema consuma un dato gia' materializzato dal modulo `Performance`

## Dove vive la logica reale

La formula resta nel dominio Sigma, non nel tema:

- `Modules\Performance\Actions\Organizzativa\UpdatepercParttimepondDalal`
- `Modules\Sigma\Models\Traits\Mutators\SchedaMutator`

Il tema vede solo il risultato finale: il campo
`perc_parttimepond_dalal` valorizzato sul record `Organizzativa`.

## Relazione con la pipeline

`OrganizzativaMoney` esegue prima `UpdateGgPresenzaDalalAction` e poi
`UpdatepercParttimepondDalal`, perche' il coefficiente ponderato dipende anche dai
giorni di presenza gia' consolidati.

Per il tema questo implica che:

- `gg_presenza_dalal` e `perc_parttimepond_dalal` vanno letti come dati derivati
  affidabili
- eventuali viste, export o badge devono limitarsi a presentarli bene
- ogni formula resta responsabilita' del dominio, non del layer di presentazione

## Esempio di consumo lato tema

```php
use Modules\Performance\Models\Organizzativa;

$organizzativa = Organizzativa::query()
    ->where('anno', 2024)
    ->where('matr', $matricola)
    ->first();

$coefficientePartTime = $organizzativa?->perc_parttimepond_dalal;
```

## UpdateGgAnnoAction

Questa action materializza `gg_anno` - i giorni di presenza per l'intero anno.

### Differenza con UpdateGgPresenzaDalalAction

| Action | Campo | Range |
|--------|-------|-------|
| `UpdateGgPresenzaDalalAction` | `gg_presenza_dalal` | `dal` → `al` della scheda |
| `UpdateGgAnnoAction` | `gg_anno` | 01/01 → 31/12 (anno intero) |

### Logica NULL o 0

L'action seleziona record dove:
- `gg_anno IS NULL` - mai calcolato
- `gg_anno = 0` - inizializzato a zero ma non calcolato

Questo garantisce che anche record con valore 0 vengano ricalcolati.

### Cosa deve sapere il tema

- il tema **non** calcola i giorni di presenza
- il tema **non** deve replicare la logica anno fiscale
- il tema consuma il valore gia' materializzato dal modulo

### Utilizzo UI

Il campo `gg_anno` puo' essere usato per:

- confronti annuali tra dipendenti
- reportistica fiscale annuale
- indicatori di presenza annuale
- esportazioni dati IRPEF/buste paga

Esempio:

```php
use Filament\Tables\Columns\TextColumn;

TextColumn::make('gg_anno')
    ->numeric()
    ->suffix(' gg')
    ->color(fn (float $state): string => $state < 200 ? 'warning' : 'success');
```

## Collegamenti

- [Documentazione modulo Performance - giorni presenza](../../Modules/Performance/docs/action-update-gg-presenza-dalal.md)
- [Documentazione modulo Performance - giorni anno](../../Modules/Performance/docs/action-update-gg-anno.md)
- [Documentazione modulo Performance - part-time ponderato](../../Modules/Performance/docs/action-update-perc-parttimepond-dalal.md)
- [README tema Zero](./README.md)
- [Index documentazione tema Zero](./index.md)

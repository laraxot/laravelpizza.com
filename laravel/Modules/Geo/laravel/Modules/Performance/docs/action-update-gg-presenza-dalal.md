# UpdateGgPresenzaDalalAction

## Scopo

`UpdateGgPresenzaDalalAction` serve a materializzare il campo `gg_presenza_dalal`
sulle schede `Organizzativa` che ne sono ancora prive.

Il suo scopo non e' "calcolare in proprio" i giorni di presenza, ma far eseguire
in batch la business logic gia' ufficiale del dominio Sigma, cosi' il valore viene
persistito una volta e poi riutilizzato dalle action successive.

## Punto chiave

La formula vera di `gg_presenza_dalal` **non** vive in questa action.

La sorgente di verita' e':

- `Modules\Performance\Models\Organizzativa` estende `BaseIndividualeModel`, che usa il trait Sigma `EnteMatrDateRangeMutator` (nessun trait duplicato sulla figlia: DRY)
- il mutator Sigma `EnteMatrDateRangeMutator`
- la relazione `qua00f()`
- lo scope `withDays(...)`

In pratica:

1. il record legge `dal` e `al`
2. Sigma converte il range in date confrontabili
3. la relazione `qua00f()` recupera le righe presenze nel periodo
4. la somma dei `days` produce `gg_presenza_dalal`
5. al primo accesso il valore viene salvato automaticamente sul record

Questo pattern evita di duplicare formula, query e regole in piu' punti.

## Perche' esiste l'action

Senza questa action, il valore verrebbe materializzato solo quando un singolo record
accede all'accessor.

Con questa action, invece, il sistema puo':

- popolare tutti i record mancanti di un anno/tipo
- preparare i dati prima dei calcoli economici
- mantenere DRY la business logic
- lasciare il calcolo al modello e usare l'action solo come orchestratore

## Cosa fa davvero

`execute(string $year, string $type)`:

1. seleziona le schede `Organizzativa` con:
   - `anno = $year`
   - `type = $type`
   - `gg_presenza_dalal IS NULL`
2. le scorre in batch
3. per ogni record forza l'accesso a `getAttribute('gg_presenza_dalal')`
4. l'accessor Sigma calcola e persiste il valore

Quindi l'action materializza i dati, ma **non** contiene una SQL di dominio propria.

## Cosa non deve fare

Questa action non deve:

- introdurre una formula alternativa a quella del mutator Sigma
- duplicare query raw su tabelle presenze
- diventare il nuovo punto di verita' del calcolo
- interpretare il tema o la UI come sorgente del dato

Se cambia la regola di business dei giorni presenza, si aggiorna il mutator Sigma,
non questa action.

## Utilizzo in OrganizzativaMoney

La pagina `OrganizzativaMoney` usa questa action come primo passo della pipeline
di ricalcolo:

```php
$year = (string) ($this->record->anno ?? 0);

app(ActionsOrgaizzativa\UpdateGgPresenzaDalalAction::class)->execute($year, 'dip');
app(ActionsOrgaizzativa\UpdatepercParttimepondDalal::class)->execute($year, 'dip');
app(ActionsOrgaizzativa\UpdateAssenzeAction::class)->execute($year, 'dip');
app(ActionsOrgaizzativa\UpdateQuotaTeoricaAction::class)->execute($year, 'dip');
```

Il senso della chiamata all'interno di `getViewData()` e' questo:

- la pagina si comporta come entrypoint di ricalcolo per l'anno del record corrente
- `gg_presenza_dalal` viene preparato prima delle action economiche successive
- `perc_parttimepond_dalal` puo' poi essere materializzato sulla stessa base giorni
- le action che dipendono da dati gia' consolidati lavorano su un dataset coerente

## Dipendenze funzionali

### Modello

- `../app/Actions/Organizzativa/UpdateGgPresenzaDalalAction.php`
- `../app/Filament/Resources/PerformanceFondoResource/Pages/OrganizzativaMoney.php`

### Dominio Sigma

- `../../Sigma/app/Models/Traits/Mutators/EnteMatrDateRangeMutator.php`
- `../../Sigma/docs/accessor-delegation-pattern.md`

## Impatto sulle action successive

Le action economiche che seguono non devono ricalcolare le presenze.
Devono assumere che `gg_presenza_dalal` sia gia' stato materializzato correttamente.

Questo rende piu' chiara la responsabilita':

- Sigma decide **come** si calcola il dato
- Performance decide **quando** materializzarlo nella pipeline

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

## Collegamenti

- [Modulo Performance](./README.md)
- [UpdatepercParttimepondDalal](./action-update-perc-parttimepond-dalal.md)
- [Performance fondo record pages](./performance-fondo-record-pages.md)
- [Accessor delegation pattern nel modulo Sigma](../../Sigma/docs/accessor-delegation-pattern.md)
- [Performance actions reference nel tema Zero](../../Themes/Zero/docs/performance-actions-reference.md)

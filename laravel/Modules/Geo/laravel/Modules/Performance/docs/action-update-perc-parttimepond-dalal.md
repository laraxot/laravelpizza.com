# UpdatepercParttimepondDalal

## Scopo

`UpdatepercParttimepondDalal` serve a materializzare il campo
`perc_parttimepond_dalal` sulle schede `Organizzativa` che ne sono ancora
prive.

Il nome resta allineato alla pipeline gia' presente in `OrganizzativaMoney`.
Se nel codice storico compare anche `UpdatePercParttimepondDalalAction`, quello
va trattato come alias compatibile, non come seconda sorgente di business logic.

Il suo scopo non e' introdurre una nuova formula di calcolo, ma far eseguire in
batch la business logic gia' ufficiale del dominio Sigma, cosi' il valore viene
persistito una volta e poi riutilizzato dalle action economiche successive.

## Punto chiave

La formula vera di `perc_parttimepond_dalal` **non** vive in questa action.

La sorgente di verita' e':

- il modello `Modules\Performance\Models\Organizzativa`
- il mutator Sigma `SchedaMutator`
- gli accessor gia' esistenti per:
  - `perc_parttime_dalal`
  - `gg_parttimevert_dalal`
  - `gg_presenza_dalal`

In pratica:

1. il record legge `perc_parttimepond_dalal`
2. se il valore manca, Sigma delega il calcolo a `getPercParttimepondDalal()`
3. il metodo usa i tre dati di base gia' delegati ai rispettivi accessor
4. il risultato viene persistito automaticamente sul record

Questo pattern evita di duplicare formula, query e regole in piu' punti.

## Formula di dominio

La formula usata dal mutator Sigma e':

```text
perc_parttimepond_dalal = perc_parttime_dalal * (1 - (gg_parttimevert_dalal / gg_presenza_dalal))
```

Caso limite importante:

- se `gg_presenza_dalal = 0`, il risultato e' `0`

Questa regola resta di proprieta' del dominio Sigma, non dell'action
Performance.

## Perche' esiste l'action

Senza questa action, il valore verrebbe materializzato solo quando un singolo
record accede all'accessor.

Con questa action, invece, il sistema puo':

- popolare tutti i record mancanti di un anno/tipo
- preparare il moltiplicatore part-time prima dei calcoli economici
- mantenere DRY la business logic
- lasciare il calcolo al modello e usare l'action solo come orchestratore

## Cosa fa davvero

`execute(string $year, string $type)`:

1. seleziona le schede `Organizzativa` con:
   - `anno = $year`
   - `type = $type`
   - `perc_parttimepond_dalal IS NULL`
2. le scorre in batch
3. per ogni record forza l'accesso a `perc_parttimepond_dalal`
4. l'accessor Sigma calcola e persiste il valore

Quindi l'action materializza i dati, ma **non** contiene una SQL di dominio
propria.

## Dipendenze funzionali

### Action precedente nella pipeline

Prima di questa action, `OrganizzativaMoney` esegue
`UpdateGgPresenzaDalalAction`, perche' `gg_presenza_dalal` e' una delle basi
del calcolo ponderato.

### Dominio Sigma

- `../../Sigma/app/Models/Traits/Mutators/EnteMatrDateRangeMutator.php`
- `../../Sigma/app/Models/Traits/Mutators/SchedaMutator.php`
- `../../Sigma/docs/accessor-delegation-pattern.md`

## Utilizzo in OrganizzativaMoney

La pagina `OrganizzativaMoney` usa questa action subito dopo
`UpdateGgPresenzaDalalAction`:

```php
$year = (string) ($this->record->anno ?? 0);

app(ActionsOrgaizzativa\UpdateGgPresenzaDalalAction::class)->execute($year, 'dip');
app(ActionsOrgaizzativa\UpdatepercParttimepondDalal::class)->execute($year, 'dip');
app(ActionsOrgaizzativa\UpdateAssenzeAction::class)->execute($year, 'dip');
```

Il senso della chiamata all'interno di `getViewData()` e' questo:

- la pagina si comporta come entrypoint di ricalcolo per l'anno del record
  corrente
- il coefficiente part-time ponderato viene preparato prima di quota teorica,
  budget assegnato e quota effettiva
- le action economiche che usano `perc_parttimepond_dalal` lavorano su un
  dataset coerente

## Impatto sulle action successive

Le action economiche che seguono non devono ricalcolare questo coefficiente.
Devono assumere che `perc_parttimepond_dalal` sia gia' stato materializzato
correttamente.

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
- [UpdateGgPresenzaDalalAction](./action-update-gg-presenza-dalal.md)
- [Performance fondo record pages](./performance-fondo-record-pages.md)
- [Accessor delegation pattern nel modulo Sigma](../../Sigma/docs/accessor-delegation-pattern.md)
- [Performance actions reference nel tema Zero](../../Themes/Zero/docs/performance-actions-reference.md)
- [Checklist fillable del modello Organizzativa](./model-fillable-checklist.md)

# Module Filament Component Autoload Rule

## Regola

Nei moduli Laraxot i componenti PHP autoloadabili devono stare sotto `app/`. Per i componenti Filament del modulo UI il path corretto e':

`Modules/UI/app/Filament/Forms/Components/...`

Non usare path paralleli fuori da `app/` per classi namespaced `Modules\UI\...`.

## Perche'

L'errore recente su `EnumSelect` non era un problema del widget Fixcity ma di autoload: il file era stato creato nel path sbagliato e Laravel non trovava la classe `Modules\UI\Filament\Forms\Components\EnumSelect`.

## Best Practices

- creare classi PHP del modulo solo sotto `app/` salvo convenzioni esplicite diverse
- verificare sempre namespace e PSR-4 insieme al path fisico
- dopo aggiunta/spostamento classe, fare un controllo rapido sulla route che la usa
- tenere i componenti Filament riusabili nel modulo owner, non duplicati in tema o modulo consumer

## Bad Practices

- mettere una classe namespaced `Modules\UI\...` in `Modules/UI/Filament/...`
- avere due copie della stessa classe in path diversi
- correggere il codice consumer quando il problema reale e' l'autoload
- introdurre workaround nel widget per compensare una classe non trovata

## False Friends

- `php -l` sul file non garantisce che Composer lo autoloaddi
- una classe "esiste nel repo" non significa che Laravel la possa risolvere
- il fatal su un widget consumer non implica che il bug sia nel consumer
- `optimize:clear` non basta se il file sta nel namespace/path sbagliato

## Check rapido

1. namespace coerente con il path sotto `app/`
2. file unico, nessun duplicato shadow
3. route reale che istanzia il componente
4. solo dopo, eventuale clear cache

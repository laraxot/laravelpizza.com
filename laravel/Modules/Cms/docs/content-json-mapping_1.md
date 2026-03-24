# Mappatura tra Slug e File JSON

## Indice
- [Introduzione](#introduzione)
- [Architettura del Sistema](#architettura-del-sistema)
- [Il Trait SushiToJsons](#il-trait-sushitojsons)
- [Flusso di Caricamento dei Contenuti](#flusso-di-caricamento-dei-contenuti)
- [Perché lo Slug "home" è Collegato al File 1.json](#perché-lo-slug-home-è-collegato-al-file-1json)
- [Vantaggi di Questa Architettura](#vantaggi-di-questa-architettura)
- [Personalizzazione e Estensione](#personalizzazione-e-estensione)

## Introduzione

In questo sistema, i contenuti delle pagine sono gestiti tramite file JSON memorizzati in una directory specifica. Questo documento spiega in dettaglio come funziona il meccanismo che collega uno slug di pagina (come "home") a un file JSON specifico (come `1.json`).

## Architettura del Sistema

Il sistema di gestione dei contenuti si basa su diversi componenti chiave:

1. **Modello Page**: Definito in `Modules/Cms/app/Models/Page.php`, rappresenta una pagina del sito
2. **Trait SushiToJsons**: Definito in `Modules/Tenant/app/Models/Traits/SushiToJsons.php`, gestisce il caricamento dei dati dai file JSON
3. **ThemeComposer**: Definito in `Modules/Cms/app/View/Composers/ThemeComposer.php`, fornisce metodi per visualizzare i contenuti delle pagine
4. **TenantService**: Definito in `Modules/Tenant/app/Services/TenantService.php`, gestisce i percorsi dei file specifici del tenant

Questa architettura implementa un pattern di "database virtuale" basato su file JSON, utilizzando la libreria [Sushi](https://github.com/calebporzio/sushi) che permette di trattare dati non-database come modelli Eloquent.

## Il Trait SushiToJsons

Il trait `SushiToJsons` è il componente centrale che gestisce la mappatura tra gli slug delle pagine e i file JSON. Ecco come funziona:

```php
trait SushiToJsons
{
    use \Sushi\Sushi;

    public function getSushiRows(): array
    {
        $tbl = $this->getTable();
        $path = TenantService::filePath('database/content/'.$tbl);
        $files = File::glob($path.'/*.json');
        $rows = [];
        foreach ($files as $id => $file) {
            $json = File::json($file);
            $item = [];
            foreach ($this->schema ?? [] as $name => $type) {
                $value = $json[$name] ?? null;
                if (is_array($value)) {
                    $value = json_encode($value, JSON_PRETTY_PRINT);
                }
                $item[$name] = $value;
            }
            $rows[] = $item;
        }

        return $rows;
    }

    public function getJsonFile(): string
    {
        Assert::string($tbl = $this->getTable());
        Assert::string($id = $this->getKey());

        $filename = 'database/content/'.$tbl.'/'.$id.'.json';

        $file = TenantService::filePath($filename);

        return $file;
    }
    
    // Altri metodi...
}
```

Questo trait implementa due metodi fondamentali:

1. **getSushiRows()**: Carica tutti i file JSON dalla directory corrispondente alla tabella del modello e li converte in un array di righe che Sushi può utilizzare come "database virtuale"
2. **getJsonFile()**: Determina il percorso del file JSON corrispondente a un'istanza specifica del modello

## Flusso di Caricamento dei Contenuti

Quando viene richiesta la homepage, il flusso di caricamento dei contenuti è il seguente:

1. Il template `index.blade.php` chiama `$_theme->showPageContent('home')`
2. Il metodo `showPageContent` nel `ThemeComposer` cerca una pagina con lo slug "home":
   ```php
   public function showPageContent(string $slug): Renderable
   {
       Assert::isInstanceOf($page = Page::firstOrCreate(['slug' => $slug], ['title' => $slug, 'content_blocks' => []]), Page::class, '['.__LINE__.']['.__FILE__.']');

       $blocks = $page->content_blocks;

       if (! is_array($blocks)) {
           $blocks = [];
       }
       $page = new \Modules\UI\View\Components\Render\Blocks(blocks: $blocks, model: $page);

       return $page->render();
   }
   ```
3. Il modello `Page` utilizza il trait `SushiToJsons` per caricare i dati dai file JSON
4. Il metodo `getSushiRows()` carica tutti i file JSON dalla directory `database/content/pages/`
5. Sushi converte questi dati in un "database virtuale" che il modello `Page` può interrogare
6. Quando viene eseguita la query `Page::firstOrCreate(['slug' => 'home'], ...)`, Sushi cerca tra i dati caricati una riga con lo slug "home"
7. Se trova una corrispondenza (in questo caso nel file `1.json`), restituisce quella riga come istanza del modello `Page`
8. I blocchi di contenuto vengono estratti dal modello e passati al componente `Blocks` per il rendering

## Perché lo Slug "home" è Collegato al File 1.json
Questo avviene perché il trait `SushiToJsons` carica tutti i JSON in `/config/local/<nome progetto>/database/content/pages/`, e la query Eloquent `Page::firstOrCreate(['slug'=>'home'], ...)` cerca nello "slug" interno di ogni file. Il file `1.json` contiene `"slug": "home"`, perciò viene restituito.

Consulta anche la documentazione di riferimento in root: ../../../../docs/gestione-homepage.md

## Vantaggi di Questa Architettura

Questa architettura offre numerosi vantaggi:

1. **Semplicità**: I contenuti sono memorizzati in file JSON facilmente modificabili
2. **Versionamento**: I file JSON possono essere versionati con Git
3. **Portabilità**: I contenuti possono essere facilmente trasferiti tra ambienti
4. **Flessibilità**: Nuove pagine possono essere aggiunte semplicemente creando nuovi file JSON
5. **Interfaccia Familiare**: Grazie a Sushi, i dati possono essere manipolati utilizzando l'API di Eloquent
6. **Multi-tenancy**: Il `TenantService` permette di avere contenuti specifici per ogni tenant

## Personalizzazione e Estensione

Per personalizzare o estendere questo sistema:

1. **Aggiungere Nuove Pagine**: Creare un nuovo file JSON nella directory `database/content/pages/` con un ID univoco e uno slug appropriato
2. **Modificare Pagine Esistenti**: Modificare il file JSON corrispondente alla pagina desiderata
3. **Estendere il Modello Page**: Aggiungere nuovi campi o metodi al modello `Page` per supportare nuove funzionalità
4. **Personalizzare il Rendering**: Modificare il componente `Blocks` o creare nuovi componenti per supportare nuovi tipi di blocchi di contenuto

## Conclusione

Il sistema di mappatura tra slug e file JSON è un esempio di un'architettura ben progettata che combina la semplicità dei file JSON con la potenza dei modelli Eloquent. Questo approccio offre un modo flessibile e manutenibile per gestire i contenuti delle pagine, consentendo agli sviluppatori di concentrarsi sulla creazione di un'esperienza utente eccellente senza doversi preoccupare della complessità del backend.

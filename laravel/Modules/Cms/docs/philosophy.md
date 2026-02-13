# Modulo Cms - Filosofia, Religione, Politica, Zen

## 🎯 Panoramica

Il modulo Cms è il sistema di gestione dei contenuti per l'architettura Laraxot, responsabile della gestione di pagine, menu, sezioni e blocchi di contenuto. La sua filosofia è incentrata sulla **flessibilità, la modularità e la type safety**, garantendo che i contenuti siano facilmente gestibili, traducibili e renderizzabili in modo coerente.

## 🏛️ Filosofia: Contenuto Strutturato e Modulare

### Principio: Il Contenuto è un Sistema di Blocchi Compositi

La filosofia di Cms si basa sull'idea che il contenuto web debba essere strutturato in blocchi modulari e componibili, piuttosto che in pagine monolitiche. Questo approccio permette la massima flessibilità nella creazione e gestione dei contenuti, facilitando la riusabilità e la manutenzione.

- **Blocchi Compositi**: Ogni contenuto è composto da blocchi (`BlockData`) che possono essere combinati in modo flessibile.
- **Separazione Contenuto/Presentazione**: Il contenuto è separato dalla sua presentazione, permettendo cambiamenti di design senza modificare i dati.
- **Multi-Localizzazione**: Supporto nativo per contenuti multi-lingua attraverso `BaseModelLang` e il trait `HasTranslations`.
- **Sushi Models**: Utilizzo di modelli Sushi (`SushiToJsons`) per configurazioni leggere e performanti.

## 📜 Religione: La Sacra Gerarchia dei Contenuti

### Principio: Ogni Contenuto ha il Suo Posto nella Gerarchia

La "religione" di Cms si manifesta nella rigorosa aderenza a una gerarchia ben definita dei contenuti, dove ogni elemento ha un ruolo preciso e relazioni chiare con gli altri.

- **Gerarchia Pagine**: `Page` è l'entità principale, contenente `content_blocks`, `sidebar_blocks` e `footer_blocks`.
- **Menu Gerarchici**: `Menu` utilizza `HasRecursiveRelationshipsContract` e `TypedHasRecursiveRelationships` per gestire strutture ad albero complesse.
- **Sezioni e Blocchi**: `Section` contiene `blocks`, che a loro volta sono composti da `BlockData`.
- **BaseTreeModel**: Modello astratto per entità gerarchiche, garantendo coerenza nell'implementazione delle relazioni ricorsive.

### Esempio: Struttura Gerarchica di `Menu`

```php
// Modules/Cms/app/Models/Menu.php
namespace Modules\Cms\Models;

use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Modules\Xot\Models\Traits\TypedHasRecursiveRelationships;

class Menu extends BaseModel implements HasRecursiveRelationshipsContract
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    
    // Menu può avere parent e children, formando una struttura ad albero
    // Utilizza i metodi del contratto: parent(), children(), ancestors(), descendants()
}
```
Questa implementazione garantisce che i menu seguano una struttura gerarchica rigorosa e type-safe, un pilastro della "religione" di Cms.

## ⚖️ Politica: Type Safety e Compilazione Sicura (PHPStan Livello 10)

### Principio: Ogni Blocco è Type-Safe, Ogni View è Verificata

La "politica" di Cms è l'applicazione rigorosa della type safety, specialmente nella gestione dei blocchi di contenuto e nella compilazione delle view. Ogni blocco deve essere validato e ogni view deve esistere prima del rendering.

- **PHPStan Livello 10**: Tutti i componenti del modulo Cms devono passare l'analisi statica al livello massimo.
- **`BlockData` Type Safety**: La classe `BlockData` garantisce che ogni blocco abbia un `type`, `data` e `view` validi, verificando l'esistenza della view prima dell'istanziazione.
- **`HasBlocks` Trait**: Il trait `HasBlocks` gestisce la compilazione sicura dei blocchi, supportando Blade rendering e traduzioni.
- **`SushiToJsons`**: I modelli Sushi garantiscono che i dati JSON siano sempre validi e type-safe.

### Esempio: `BlockData` e Validazione View

```php
// Modules/Cms/app/Datas/BlockData.php
namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

class BlockData extends Data implements Wireable
{
    public string $type;
    public array $data;
    public string $view;

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
        Assert::string($view = Arr::get($data, 'view', 'ui::empty'));
        if (! view()->exists($view)) {
            throw new Exception('view not found: '.$view);
        }
        $this->view = $view;
    }
}
```
Questo approccio garantisce che ogni blocco sia sempre valido e che la sua view esista prima del rendering, un aspetto cruciale della "politica" di Cms.

## 🧘 Zen: Semplicità e Auto-Scoperta

### Principio: Il Contenuto si Auto-Organizza

Lo "zen" di Cms si manifesta nella preferenza per l'auto-scoperta e le convenzioni rispetto alla configurazione esplicita. Il modulo mira a rendere la gestione dei contenuti il più intuitiva possibile.

- **Auto-Scoping per Slug**: Le pagine e le sezioni sono identificate automaticamente tramite `slug`, eliminando la necessità di configurazioni complesse.
- **Blade Compilation Automatica**: Il trait `HasBlocks` compila automaticamente le espressioni Blade nei blocchi, senza intervento manuale.
- **Traduzione Automatica**: I modelli `BaseModelLang` gestiscono automaticamente le traduzioni, utilizzando la lingua primaria come fallback.
- **View Components**: I componenti Blade (`Page`, `PageContent`) gestiscono automaticamente il rendering dei blocchi, senza configurazione esplicita.

### Esempio: `PageContent` Component

```php
// Modules/Cms/app/View/Components/PageContent.php
namespace Modules\Cms\View\Components;

use Modules\Cms\Models\Page as PageModel;
use Modules\Cms\Datas\BlockData;

class PageContent extends Component
{
    public function __construct(string $slug)
    {
        $page = PageModel::firstOrCreate(
            ['slug' => $slug],
            ['title' => $slug, 'content_blocks' => []]
        );
        $blocks = $page->content_blocks;
        if (! is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            $blocks = $page->getTranslation('content_blocks', $primary_lang);
        }
        $this->blocks = BlockData::collect($blocks);
    }
}
```
Questo componente incarna lo zen dell'auto-scoperta, creando automaticamente la pagina se non esiste e gestendo le traduzioni senza configurazione esplicita.

## 📚 Riferimenti Interni

- [Documentazione Master del Progetto](../../../docs/project-master-analysis.md)
- [Filosofia Completa Laraxot](../../Xot/docs/philosophy-complete.md)
- [Regole Critiche di Architettura](../../Xot/docs/critical-architecture-rules.md)
- [Relazioni Ricorsive (Contratto)](../../Xot/docs/recursive-relationships-contract.md)
- [Documentazione Cms Blocks System](./content-blocks-system.md)
- [Documentazione Cms Architecture](./architecture/)


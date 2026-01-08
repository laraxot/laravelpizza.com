# Homepage di il progetto

## Indice
- [Introduzione](#introduzione)
- [Struttura e Funzionamento](#struttura-e-funzionamento)
- [Gestione dei Contenuti](#gestione-dei-contenuti)
- [Personalizzazione](#personalizzazione)
- [Documentazione Dettagliata](#documentazione-dettagliata)

## Introduzione

La homepage di il progetto rappresenta il punto di ingresso principale per gli utenti del portale. È progettata per fornire informazioni chiare e accessibili sui servizi offerti, con particolare attenzione alle pazienti vulnerabili in stato di gravidanza. Questo documento fornisce una panoramica della struttura e del funzionamento della homepage, con collegamenti alla documentazione dettagliata.

## Struttura e Funzionamento

La homepage di il progetto è implementata utilizzando un'architettura modulare che separa la presentazione dai contenuti. Il template principale si trova in:

```
/laravel/Themes/One/resources/views/pages/index.blade.php
```

Questo file utilizza:
- **Laravel Folio** per la gestione del routing
- **Livewire Volt** per i componenti reattivi
- **Layout Marketing** per la struttura generale della pagina
- **ThemeComposer** per il caricamento dei contenuti

Il template è volutamente semplice e delega la visualizzazione dei contenuti al metodo `showPageContent`:

```php
<x-layouts.marketing>
    <div>
        {!! $_theme->showPageContent('home') !!}
    </div>
</x-layouts.marketing>
```

## Gestione dei Contenuti

I contenuti della homepage sono definiti in un file JSON:

```
/laravel/config/local/<nome progetto>/database/content/pages/1.json
```

Questo file contiene una struttura che definisce i blocchi di contenuto della homepage, organizzati per lingua:

```json
{
    "id": "1",
    "title": {
        "it": "il progetto - Promozione della <slogan> per le gestanti"
    },
    "slug": "home",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "view": "ui::components.blocks.hero.simple",
                    "title": "Benvenuta su <slogan>,",
                    "subtitle": "...",
                    "image": "/img/hero-bg.jpg",
                    "cta_text": "INIZIA ORA",
                    "cta_link": "{{ route('register') }}"
                }
            },
            // Altri blocchi di contenuto...
        ]
    }
}
```

I tipi di blocchi disponibili sono:
1. **hero** - Sezione principale con titolo, sottotitolo e call-to-action
2. **paragraph** - Blocco di testo semplice
3. **feature_sections** - Sezioni con caratteristiche e funzionalità
4. **stats** - Sezioni con statistiche
5. **cta** - Call-to-action

## Personalizzazione

Per modificare la homepage di il progetto, ci sono due approcci principali:

### 1. Modificare i Contenuti

Per modificare i contenuti, è sufficiente aggiornare il file JSON:
```
/laravel/config/local/<nome progetto>/database/content/pages/1.json
```

È possibile:
- Modificare testi, immagini e altri dati nei blocchi esistenti
- Aggiungere nuovi blocchi di contenuto
- Riordinare o rimuovere blocchi esistenti

### 2. Modificare il Template

Per modifiche strutturali più profonde:
- Aggiornare il layout marketing
- Modificare i componenti utilizzati dai blocchi
- Creare nuovi tipi di blocchi

## Documentazione Dettagliata

Per una documentazione più approfondita sull'architettura della homepage, consulta:

- [Architettura della Homepage](../laravel/Modules/Cms/docs/homepage_architecture.md) - Analisi dettagliata del funzionamento della homepage
- [Gestione dei Contenuti](../laravel/Modules/Cms/docs/content.md) - Come gestire i contenuti tramite file JSON
- [Frontoffice](../laravel/Modules/Cms/docs/frontoffice.md) - Panoramica del frontoffice di il progetto

## Riferimenti

- [Architettura del Frontoffice](./architettura_frontoffice.md) - Panoramica dell'architettura del frontoffice
- [Regole per i Collegamenti nella Documentazione](./regole_collegamenti_documentazione.md) - Linee guida per i collegamenti nella documentazione

## Collegamenti Bidirezionali
- [README](README.md) - Documentazione principale del modulo
- [Architettura](homepage_architecture.md) - Architettura della homepage
- [Gestione](homepage-management.md) - Gestione della homepage
- [Struttura](homepage-structure.md) - Struttura dettagliata
- [Contenuti](homepage-contenuti.md) - Gestione dei contenuti
- [Errori Comuni](homepage-errori-comuni.md) - Problemi e soluzioni
- [Frontoffice](frontoffice.md) - Integrazione con il frontoffice

## Vedi Anche
- [Modulo UI](../UI/docs/README.md) - Componenti UI per la homepage
- [Modulo Theme](../Theme/docs/README.md) - Personalizzazione tema
- [Modulo Lang](../Lang/docs/README.md) - Gestione traduzioni
- [Gestione Contenuti](content-management.md) - Sistema di gestione contenuti
- [Sezioni](sections.md) - Gestione delle sezioni
- [Layout](struttura-layout-componenti-blade-<nome progetto>.md) - Struttura dei layout

# Modulo CMS

## Descrizione
Il modulo CMS gestisce i contenuti, le pagine e i temi dell'applicazione. Fornisce un'interfaccia completa per la gestione dei contenuti e l'integrazione con i temi frontend.

## Gestione dei Temi
Il modulo CMS include funzionalità per la gestione dei temi, inclusi:

- **Compilazione dei temi**: Processo di build con Vite
- **Pubblicazione degli asset**: Copia degli asset compilati nelle directory pubbliche
- **Gestione degli errori**: Risoluzione di problemi comuni

### Documentazione Dettagliata
- [Compilazione e Pubblicazione dei Temi](/Modules/Cms/docs/theme_compilation.md)
- [Errori Vite Manifest](/Modules/Cms/docs/theme_compilation.md#errore-unable-to-locate-file-in-vite-manifest)

### Esempio di Risoluzione Errore Vite
Per risolvere l'errore "Unable to locate file in Vite manifest", eseguire:

```bash
cd /var/www/html/_bases/base_fixcity_fila5_mono/laravel/Themes/Sixteen
npm run copy
```

### Temi Supportati
- **Sixteen**: Tema principale dell'applicazione
  - [Guida risoluzione errore Vite manifest](../../../Themes/Sixteen/docs/assets.md)

## Gestione dei Contenuti
Il modulo CMS offre funzionalità avanzate per la gestione dei contenuti:

- **Pagine dinamiche**: Creazione e gestione di pagine con editor visuale
- **Componenti riutilizzabili**: Blocchi di contenuto modulari
- **SEO integrato**: Gestione meta-tag e ottimizzazione per i motori di ricerca

### Documentazione Contenuti
- [Struttura Pagine](/Modules/Cms/docs/homepage-structure.md)
- [Storage Contenuti](/Modules/Cms/docs/content-storage.md)
- [Componente Page/Show](/Modules/Cms/docs/components/page-show.md) - Visualizzazione pagine con Livewire

### Componenti Livewire
- **Page/Show**: Componente per visualizzare contenuti di pagine dinamiche
  ```blade
  <x-page.show slug="home" />
  ```
  [Documentazione dettagliata](/Modules/Cms/docs/components/page-show.md)

## Integrazione con Filament
Il modulo CMS si integra con Filament per offrire un'interfaccia di amministrazione potente:

- **Form Builder**: Creazione dinamica di form per la gestione dei contenuti
- **Resource Manager**: Gestione risorse CMS con CRUD automatico

### Documentazione Filament
- [Form Filament](/Modules/Cms/docs/filament-forms.md)

## Componenti Livewire
- [Guida Livewire Page\\Show](../../../Modules/Cms/docs/livewire/page_show.md)

## Collegamenti
- [Indice generale](/docs/index.md)
- [Documentazione moduli](/docs/modules/index.md)
- [Gestione Temi](/docs/themes.md) 

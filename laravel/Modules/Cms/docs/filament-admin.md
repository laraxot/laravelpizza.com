---
title: "Cms: pannello Filament, risorse, blocchi Builder e widget"
type: concept
module: Cms
status: active
qmd: "cms filament 5 resource LangBaseResource XotBaseResource builder blocks HeaderNavBlock menu nestedset widget auth settingpage themes"
---

# Pannello Filament del Cms

Backoffice dei contenuti: Filament **^5.0** (`laravel/composer.json`), Livewire v4, Tailwind v4. Il front office non usa
Filament per le pagine (sono Folio + JSON); Filament serve a modificare pagine, sezioni, menu e allegati e a ospitare
widget (es. form di accesso) dentro i blocchi.

## Provider, risorse, pagine

| Elemento | Classe (verificata) |
|---|---|
| Pannelli | `Providers\Filament\AdminPanelProvider`, `Providers\Filament\FrontPanelProvider` |
| Risorse multilingua | `PageResource`, `SectionResource`, `PageContentResource`, `AttachmentResource` (estendono `Modules\Lang\Filament\Resources\LangBaseResource`) |
| Risorsa non tradotta | `MenuResource` (estende `XotBaseResource`) |
| Struttura risorsa | `PageResource/{Pages,Schemas,Tables}`: `PageForm`, `PageInfolist`, `PagesTable`, `CreatePage`/`EditPage`/`ListPages` |
| Pagine | `Dashboard` (`XotBaseDashboard`), `SettingPage`, `Themes` (`XotBasePage`); cluster `Appearance` |
| Front | `Filament\Front\Pages\{Home,Welcome}` |
| Campi Builder | `PageContentBuilder`, `PageContent`, `LeftSidebarContent` (`app/Filament/Fields`) |
| Blocchi Builder | `HeroBlock`, `ParagraphBlock`, `CtaBlock`, `InfoBlock`, `ContactBlock`, `StatsBlock`, `FeatureSectionsBlock`, `ActionsBlock`, `NewsletterBlock`, `QuickLinksBlock`, `LinksBlock`, `SocialBlock`, `SocialLinksBlock`, `LogoBlock`, `NavigationBlock`, `HeaderNavBlock` (`app/Filament/Blocks`) |

`Page`, `Section`, `PageContent` e `Attachment` hanno uno schema Sushi/JSON: gli slug sono ricercabili e i campi
traducibili restano tali nelle colonne. `Menu` e' ad albero con relazioni ricorsive (`HasRecursiveRelationships` di staudenmeir, colonna `parent_id`), non con nested set.

## Regole di estensione (valgono per ogni classe del modulo)

1. **Mai estendere `Filament\*` direttamente**: si estende lo specchio `Modules\Xot\Filament\...\XotBase*` allo stesso
   percorso relativo (`XotBaseResource`, `XotBasePage`, `XotBaseWidget`, `XotBaseListRecords`, `XotBaseCreateRecord`,
   `XotBaseEditRecord`, `XotBaseRelationManager`, `XotBaseViewColumn`...). Se lo specchio manca si crea in Xot, non nel modulo.
   Per le risorse tradotte si usa `LangBaseResource`.
2. `XotBaseResource` fornisce gia' `getTableColumns()`, `getTableActions()`, `getTableBulkActions()` (array con chiavi
   stringa): non riscriverli. Le colonne di tabella sono `array<string, Column>`.
3. **Mai `->label()`** nei form/tabelle: le etichette arrivano dalle traduzioni gestite dal `LangServiceProvider`
   (file `lang/<lingua>/<nome>.php`, divisi per cartella se superano le 500 righe).
4. Un tipo di blocco nuovo = una classe in `app/Filament/Blocks` + la view nel tema; il campo `data.view` deve esistere
   ([content-blocks-system.md](content-blocks-system.md)).
5. Filament 5: schema dichiarativo (`Schemas/`), `getFormSchema()` per i form; le Blade `head`/`foot` non devono perdere
   `@filamentStyles`/`@filamentScripts` ([components.md](components.md)). La compatibilita' 4.x (override `make()` di
   `SectionPreview`, tipo di `$view` nel `Dashboard`) e' stata risolta; non c'e' altro da documentare per 4.x.

## `HeaderNavBlock`

Il blocco Builder che gestisce la navigazione dell'header dal pannello: il form salva nel JSON `sections/header.json` del
tenant (via `SushiToJsons` / `SaveHeadernavConfigAction`), letto da `Section` e reso dal template
`sections/header/<tpl>.blade.php` del tema, richiamato con `<x-section slug="header" />`. I dati tipizzati sono
`HeadernavData`/`NavbarMenuData`/`LinkData`.

## Widget o pagina per i form di accesso

Nel front office multi-tenant con layout proprio, i form di login/registrazione sono pensati come **widget Filament**
incorporati nei blocchi (si integrano nel layout del tema e nelle route Folio), non come pagine Filament. Valgono le regole
1-3. La story [stories/12.1.cms-page-show-not-widget.story.md](stories/12.1.cms-page-show-not-widget.story.md) ha deciso
che `Page\Show` (visualizzazione di una pagina CMS) non va convertito in widget; l'inventario Livewire e' in
[bmad/livewire-inventory.md](bmad/livewire-inventory.md). Verificato oggi: `app/Http/Livewire` non esiste piu' nel modulo.

## Form sopra una tabella

Per creare record senza lasciare la lista: un widget con `HasForms` nell'header della `ListRecords`, che al salvataggio
emette un evento Livewire per aggiornare la tabella sottostante. Il widget estende `XotBaseWidget`; lo stesso schema
serve anche per il form della pagina di creazione (DRY).

## Allegati

`AttachmentResource` (list/create/edit) mostra titolo traducibile, slug e anteprima del file; il disco e' scelto da
`Enums\AttachmentDiskEnum`; `DownloadAttachmentPlaceHolder` mostra il link di download nelle form.

## Impostazioni e temi

`SettingPage` sceglie il tema pubblico tra quelli restituiti da `ListInstalledThemesAction` (cartelle di `Themes/` con
`resources/views`): un nome inventato farebbe fallire il boot. `Themes` e il cluster `Appearance` gestiscono l'aspetto
([theme-and-assets.md](theme-and-assets.md)).

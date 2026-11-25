---
title: "Glossario di dominio UI"
type: glossary
owner: UI
updated: 2026-11-24
qmd: "glossario UI blocchi icone slider tema layout tabella calendario orari apertura"
---

# Glossario di dominio UI

Se glossario e codice divergono vale il codice. Percorsi relativi a `laravel/Modules/UI/`.

| Termine | Significato | Nel codice |
|---|---|---|
| Blocco | Componente di contenuto riusabile (hero, heading, immagine, slider, navigazione, ...) scelto nel builder Filament. | `app/Filament/Blocks/` |
| Elenco blocchi | Scoperta dei blocchi dei moduli: nome snake dalla classe, modulo dal namespace. | `app/Actions/Block/GetAllBlocksAction.php` |
| Blocco localizzato | Dati del blocco risolti dal CMS se il modulo Cms esiste, altrimenti parametri invariati. | `app/Actions/Block/ResolveLocalizedBlockDataAction.php` |
| Slider | Dati di una slide (miniature desktop e mobile, link, titolo, descrizioni) e relativa collezione. | `app/Datas/SliderData.php`, `app/Datas/SliderDataCollection.php` |
| Configurazione UI | DTO di configurazione del modulo. | `app/Datas/UIConfigData.php` |
| Metadati tema | Colori brand, scale di spaziatura e breakpoint compilati da design token. | `app/Datas/ThemeMetadataData.php` |
| Composer del tema | View composer che fornisce i dati del tema alle view. | `app/View/Composers/ThemeComposer.php` |
| Dati utente UI | DTO dell'utente corrente per l'interfaccia (avatar, ruolo, permessi, impostazioni). | `app/Datas/UserData.php`, `app/Actions/GetUserDataAction.php` |
| Layout tabella | Modalità di visualizzazione di una tabella (`list`, `grid`). | `app/Enums/TableLayoutEnum.php` |
| Tipo campo | Enum dei tipi di campo (text, email, textarea, select, radio, checkbox, date, time, datetime). | `app/Enums/FieldTypeEnum.php` |
| Opzione di campo | Modello delle opzioni di un campo. | `app/Models/FieldOption.php` |
| Categoria | Modello di categoria del modulo UI (colonna `is_active`) e relativo blocco. | `app/Models/Category.php`, `app/Filament/Blocks/Category.php` |
| Mappatura giorni | Mappa dei giorni della settimana usata dalla validazione degli orari. | `app/Actions/Datetime/GetDaysMappingAction.php` |
| Orari di apertura | Regola di validazione del formato degli orari di apertura. | `app/Rules/OpeningHoursRule.php` |
| Icone disponibili | Elenco delle icone Blade registrate, per i selettori. | `app/Actions/Icon/GetAllIconsAction.php` |
| Componenti di interfaccia | Componenti Blade condivisi: Logo, Navbar, Sidebar, DarkModeSwitcher, Svg. | `app/View/Components/` |

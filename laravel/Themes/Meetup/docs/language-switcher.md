---
title: "Selettore lingua"
type: reference
status: active
theme: Meetup
qmd: "language switcher selettore lingua dropdown bandiere cambio lingua locale hreflang getLocalizedURL ux accessibilita"
---

# Selettore lingua

## Perche' esiste

Chi legge il sito in una lingua deve poterla cambiare restando sulla stessa pagina, con un controllo comprensibile, accessibile da tastiera e che non rompa SEO e sessione. Il tema lo fa con un componente piccolo, tutto lato server: ogni voce e' un normale link all'URL della stessa pagina nell'altra lingua. Le regole generali su URL e traduzioni sono in [localization-standard.md](localization-standard.md).

## Come e' fatto

Componente: `resources/views/components/ui/language-switcher.blade.php`, usato nell'header due volte (`<x-ui.language-switcher />` nel nav desktop, `<x-ui.language-switcher mobile />` nel menu mobile). Vedi [header-footer-logo.md](header-footer-logo.md).

- **Lingue**: `LaravelLocalization::getSupportedLocales()` (oggi `it`, `en`, `de`, `fr`, `es`, `ru`, da `config/laravellocalization.php`); si puo' passare una lista diversa con la prop `locales`. Il nome mostrato e' l'autonimo (`native`: italiano, English, Deutsch...).
- **Lingua corrente**: primo segmento dell'URL se e' tra le lingue supportate, altrimenti `app()->getLocale()`.
- **Link**: `LaravelLocalization::getLocalizedURL($code, request()->fullUrl(), [], true)`, con `hreflang` e `lang` su ogni voce e `aria-current="true"` su quella attiva. Nessun JavaScript decide la lingua, nessun cookie, nessuna rotta di cambio lingua.
- **Apertura**: Alpine (`x-data="{ open: false }"`, `@click.outside`, `@keydown.escape.window`, transizioni); animazione CSS `.lang-dropdown` (`dropdownSlide`, 0.2 s).
- **Bottone**: icona globo (`heroicon-o-globe-alt`), nome della lingua corrente (da `md` nella versione desktop, sempre nella mobile) e freccia `meetup-icon-arrow-down`. `aria-haspopup`, `:aria-expanded`, e `aria-label` = "<lingua corrente> - <pub_theme::navigation.select_language>": il nome accessibile contiene il testo visibile (WCAG 2.5.3).
- **Bandiere**: set `ui-flags` (`Modules/UI/resources/svg/flags/*.svg`, `<x-filament::icon :icon="'ui-flags.'.$flag">`; per `en` si usa `gb`). Sono decorative: il significato lo porta il nome della lingua. Segno di spunta `meetup-icon-check` sulla lingua attiva.
- **Mobile**: variante a tutta larghezza, menu allineato a sinistra, stesso link.

## Regole

1. Il cambio lingua e' un link a un URL localizzato, mai un reload dopo aver scritto un cookie con JavaScript. L'URL e' la fonte di verita' della lingua e quello che si vede e' quello che il crawler indicizza (`hreflang`).
2. La pagina corrente si mantiene con `getLocalizedURL(...)`; non si ricostruisce l'URL con espressioni regolari sul `pathname`.
3. Mostra l'autonimo, non solo la bandiera: una bandiera indica un Paese, non una lingua.
4. Almeno 44 px di area cliccabile, `focus-visible` con anello, chiusura con Esc e con click fuori.
5. Le etichette (`select_language`) stanno in `lang/<locale>/navigation.php`, mai nella Blade.
6. Se si aggiunge una lingua: voce in `supportedLocales` e `localesOrder`, bandiera nel set `ui-flags`, file in `Themes/Meetup/lang/<locale>` (vedi la copertura attuale in [localization-standard.md](localization-standard.md)).

## Errore storico: "cambio lingua ma la pagina resta in italiano"

Sintomo: dopo la selezione la pagina si ricarica ma mostra ancora l'italiano. Cosa e' emerso:

- **Causa vera**: la lingua veniva impostata solo su `app()`, non su `LaravelLocalization`; `localizeUrl()` e `getLocalizedURL()` ricadevano sull'italiano e ogni link generato tornava in `it`. Oggi `SetFolioLocale` imposta entrambi (commento nel middleware).
- **Strada scartata**: sincronizzare lingua con un cookie, un `LanguageController` e un middleware `SetLocaleFromCookie`. Era una teoria su una race condition di cookie, mai realizzata nel tema; il meccanismo di sessione di `Modules/UI` (`LanguageController`, `SetLocale`) resta separato e non e' usato dal tema.
- **Diagnosi**: prova `curl -s http://<host>/de/events | grep -o '<html[^>]*>'` e controlla che `lang="de"` coincida col prefisso; poi che i link del selettore abbiano il prefisso giusto.

## Funzioni non implementate

Ricerca nel menu, "lingue recenti", rilevamento intelligente della preferenza, metriche del cambio lingua, bandiere animate: erano nei vecchi documenti ma nel codice non ci sono. Con sei lingue un elenco semplice basta; aggiungerle solo se una misura mostra un problema reale.

## Da verificare

- Nessun test copre il selettore (il test dell'header controlla le etichette di accesso, non il menu lingua): un test Pest che visita `/it` e verifica gli `href` con prefisso e `hreflang` evita regressioni.
- Il menu e' nascosto con `x-show` senza `x-cloak`: a Alpine non ancora avviato puo' comparire un istante.
- `components/ui/language.blade.php` e' un'altra versione (bandiere SVG inline, bottoni senza link) non usata dal tema attivo.

## Vedi anche

- [localization-standard.md](localization-standard.md)
- [header-footer-logo.md](header-footer-logo.md)
- [accessibility.md](accessibility.md)
- [design-system.md](design-system.md)

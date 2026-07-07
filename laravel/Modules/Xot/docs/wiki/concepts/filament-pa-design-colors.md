# Filament — palette PA Design Comuni

## Scopo

Un solo SSoT per i colori Filament su **backoffice** e **widget FO** (login, wizard, infolist), allineato a Design Comuni e al tema Sixteen.

## Implementazione

| Pezzo | Ruolo |
|-------|--------|
| `Modules\Xot\Support\PaDesignColors` | `PRIMARY_HEX` `#007A52`, `INSTITUTIONAL_BLUE_HEX` `#0066CC`, `filamentPalette()` |
| `MetatagData::getFilamentColors()` | Delega a `PaDesignColors::filamentPalette()` |
| `ApplyMetatagToPanelAction` | `->colors($metatag->getFilamentColors())` su ogni `XotBasePanelProvider` |
| `FrontPanelProvider` (Cms) | Stessa palette via `MetatagData::make()->getFilamentColors()` |
| `XotServiceProvider::registerPaFilamentColors()` | `FilamentColor::register(PaDesignColors::filamentPalette())` — widget FO senza panel (login, wizard) |

## Palette Filament

| Chiave | Valore | Uso |
|--------|--------|-----|
| `primary` | Verde PA `#007A52` | CTA, bottoni, accenti Filament |
| `info` | Blu `#0066CC` | Messaggi informativi |
| `warning` | Orange | Avvisi (non più Amber duplicato su primary) |
| `success` / `danger` | Green / Red | Stati |

## Regola FO

Con `@filamentStyles` attivo, `FilamentColor::register(PaDesignColors::filamentPalette())` imposta `--primary-*` verde su `:root`.

**Uniformità FO:** non duplicare hex in `14-auth-login.css`. Usare `<x-filament::button color="primary">` e `.fo-filament-form-shell`. Vedi [fo-pa-tokens-uniformity.md](../../../../Themes/Sixteen/docs/architecture/fo-pa-tokens-uniformity.md).

**Link testuali:** blu Design Comuni `text-italia-blue-*` (`--dc-blue-primary`). **CTA:** verde `--fixcity-primary` via Filament.

Evitare override `Color::Amber` in panel provider locali.

## Collegamenti

- [auth-login-ux-design-wcag.md](../../../../Themes/Sixteen/docs/wiki/design/auth-login-ux-design-wcag.md)
- [metatag-data.md](../../datas/metatag-data.md)
- [applymetatagtopanelaction.md](../../actions/panel/applymetatagtopanelaction.md)

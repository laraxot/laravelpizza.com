# Documentazione Tecnica

> **NOTA**: La documentazione tecnica è stata spostata nella documentazione del modulo Xot.

Questo file contiene i collegamenti alla documentazione tecnica che si trova nel modulo Xot.

## Filament

- [Struttura Risorse Filament](../laravel/Modules/Xot/docs/filament-resources-structure.md)
- [Widget Form Filament](../laravel/Modules/Xot/docs/form_filament_widgets.md)

## Convenzioni

- [Convenzioni Laravel](../laravel/Modules/Xot/docs/laravel-conventions.md)
- [Convenzioni di Nomenclatura](../laravel/Modules/Xot/docs/naming-conventions.md)
- [Standard di Codice](../laravel/Modules/Xot/docs/standard-codice.md)

## Git e Gestione Codice

- [Git](../laravel/Modules/Xot/docs/git.md)
- [Risoluzione Conflitti Git](../laravel/Modules/Xot/docs/risoluzione_conflitti_git.md)
- [Risoluzione Conflitti Merge](../laravel/Modules/Xot/docs/risoluzione_conflitti_merge.md)
- [Risoluzione Conflitti Merge Update](../laravel/Modules/Xot/docs/risoluzione_conflitti_merge_update.md) 

## Errore Livewire MultipleRootElementsDetectedException
Se un widget Livewire/Filament genera questo errore, significa che la view restituisce più di un root element. Soluzione: racchiudere tutto in un unico <div> o <section>. Aggiornare anche la docstring del widget e la documentazione dei moduli/temi.

## Collegamenti tra versioni di xot.md
* [xot.md](docs/tecnico/packages/xot.md)
* [xot.md](docs/xot.md)

> [2025-05-28] Policy aggiornata: tutte le pagine di form devono includere solo widget Filament modulari, mai form custom. Aggiornamento policy e motivazione.

> Le view dei widget Filament devono essere solo wrapper per $this->form. Niente markup custom, niente logica Livewire/AlpineJS, niente gestione CSRF manuale. Policy aggiornata in docs/rules/filament_best_practices.md e docs/widgets/find-doctor-appointment-widget.md.

> Vietato usare ->label() e ->placeholder() nei form component. Tutte le etichette e i placeholder sono gestiti tramite i file di traduzione del modulo e il LangServiceProvider. Policy aggiornata in docs/rules/filament_best_practices.md e docs/widgets/find-doctor-appointment-widget.md.

> Vietato creare trait per una sola classe. I trait vanno creati solo se riutilizzati in più classi. Policy aggiornata in docs/rules/filament_best_practices.md e docs/comune-sushi-implementation.md.


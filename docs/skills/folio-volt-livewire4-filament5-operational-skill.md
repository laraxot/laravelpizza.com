# folio-volt-livewire4-filament5-operational-skill.md

## Scopo

Applicare in modo coerente lo stack frontend/admin ufficiale del progetto:
Folio + Volt + Livewire 4 + Filament 5 (+ Google Fonts provider).

## Procedura

1. Routing/Pagine
   - creare o modificare pagina in `resources/views/pages`
   - dichiarare metadata con helper Folio (`name`, `middleware`, ecc.)
2. Interattivita'
   - usare Volt SFC per stato/azioni locali alla pagina
   - valutare Livewire MFC solo per componenti riusabili multipagina
3. Admin Filament
   - verificare versione/pacchetti compatibili con ramo `5.x`
4. Font pannello
   - configurare `->font('Inter', provider: SpatieGoogleFontProvider::class)`
   - assicurare setup `spatie/laravel-google-fonts` prima del provider
5. Verifica
   - test route/page principali
   - test rendering componenti Livewire/Volt toccati
   - documentare decisioni in GitHub Discussion

## Comandi utili

```bash
php artisan folio:list
php artisan livewire:convert component.name --sfc
php artisan livewire:convert component.name --mfc
```

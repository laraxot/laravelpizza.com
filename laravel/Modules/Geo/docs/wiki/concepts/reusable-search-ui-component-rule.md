# Reusable search ui component rule

## Regola

Se un blocco Blade UI (search input + risultati + loading) e' applicabile a piu picker, deve essere estratto in componente riutilizzabile.

## Perche'

- evita drift tra varianti dello stesso pattern;
- riduce bug da copia/incolla;
- accelera fix visuali e i18n su un solo punto.

## Applicazione concreta

- estratto componente: `filament/components/address-search-input.blade.php`
- consumato da: `filament/forms/components/coordinate-picker.blade.php`

## Contratto Alpine minimo

Il componente assume disponibili nel contesto:

- `searchQuery`
- `searchAddress()`
- `showResults`
- `searchResults`
- `selectSearchResult(result)`
- `isSearching`

## Anti-pattern

- duplicare inline lo stesso blocco search in ogni picker;
- cambiare markup in un picker e dimenticare gli altri.

## Riferimenti

- [lit light dom map controls and sync](./lit-light-dom-map-controls-and-sync.md)
- [geo picker runtime stability best practices](./geo-picker-runtime-stability-best-practices.md)

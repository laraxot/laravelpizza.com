/**
 * Compat layer: implementazione in `map/controls/search.js`.
 * Preferire import diretto da `./controls/search.js` nel nuovo codice.
 */
export {
    toggleSearch,
    closeSearch,
    handleSearchKeydown,
    updateSearchQuery,
    executeAddressSearch,
    selectSearchResult,
    buildLocationPayload,
    renderSearch,
    renderSearchOverlayToggle,
    searchUiHandlers,
} from './controls/search.js';

/** @deprecated alias di {@link renderSearch} — passare sempre `searchUiHandlers` come secondo argomento. */
export { renderSearch as renderSearchPanel } from './controls/search.js';

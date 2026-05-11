import { html } from 'lit';
import { guard } from 'lit/directives/guard.js';

/**
 * SearchInputLit - Lit component for address search
 * Replaces Alpine directives with Lit reactive properties
 */
export class SearchInputLit extends HTMLElement {
    static get properties() {
        return {
            searchQuery: { type: String },
            showResults: { type: Boolean },
            isSearching: { type: Boolean },
            searchResults: { type: Array }
        };
    }

    constructor() {
        super();
        this.searchQuery = '';
        this.showResults = false;
        this.isSearching = false;
        this.searchResults = [];
        this._boundOnInput = this._onInput.bind(this);
        this._boundOnEscape = this._onEscape.bind(this);
        this._boundOnClickAway = this._onClickAway.bind(this);
    }

    connectedCallback() {
        this.render();
        document.addEventListener('click', this._boundOnClickAway);
    }

    disconnectedCallback() {
        document.removeEventListener('click', this._boundOnClickAway);
    }

    render() {
        this.innerHTML = `
            <div class="relative items-center gap-2">
                <div class="relative group">
                    <input type="text"
                        class="fi-input block w-full border-none bg-white py-1.5 pl-10 pr-3 text-sm text-gray-950 shadow-sm ring-1 ring-gray-950/10 transition duration-75 focus-within:ring-2 focus-within:ring-primary-600 dark:bg-white/5 dark:text-white dark:ring-white/20 dark:focus-within:ring-primary-500 rounded-lg"
                        placeholder="Cerca indirizzo..."
                        @input="${this._boundOnInput}"
                        @keydown.escape="${this._boundOnEscape}">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg aria-hidden="true" viewBox="0 0 24 24" class="h-4 w-4 min-h-4 min-w-4 block" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    ${this.isSearching ? `
                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                        <svg aria-hidden="true" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" class="animate-spin" />
                        </svg>
                    </div>` : ''}
                </div>

                ${this.showResults && this.searchResults.length > 0 ? `
                <ul class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-lg bg-white py-1 shadow-lg ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/10">
                    ${this.searchResults.map(res => `
                        <li data-place-id="${res.place_id}" class="cursor-pointer px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-white/5">
                            <span>${res.display_name}</span>
                        </li>
                    `).join('')}
                </ul>` : ''}
            </div>
        `;

        // Attach event listeners to dynamic content
        this._attachEventListeners();
    }

    _attachEventListeners() {
        const input = this.querySelector('input');
        if (input) {
            input.addEventListener('input', this._boundOnInput);
            input.addEventListener('keydown', this._boundOnEscape);
        }

        this.querySelectorAll('li').forEach(li => {
            li.addEventListener('click', (e) => {
                const placeId = li.dataset.placeId;
                const result = this.searchResults.find(r => r.place_id.toString() === placeId);
                if (result) {
                    this.dispatchEvent(new CustomEvent('search-result-selected', {
                        detail: result,
                        bubbles: true,
                        composed: true
                    }));
                    this.showResults = false;
                    this.render();
                }
            });
        });
    }

    _onInput(e) {
        this.searchQuery = e.target.value;
        if (this.searchQuery.length > 2) {
            this.showResults = true;
        } else {
            this.showResults = false;
        }
        this.dispatchEvent(new CustomEvent('search-input', {
            detail: { query: this.searchQuery },
            bubbles: true,
            composed: true
        }));
        this.render();
    }

    _onEscape(e) {
        if (e.key === 'Escape') {
            this.showResults = false;
            this.render();
        }
    }

    _onClickAway(e) {
        if (!this.contains(e.target)) {
            this.showResults = false;
            this.render();
        }
    }

    setResults(results) {
        this.searchResults = results || [];
        this.isSearching = false;
        this.render();
    }

    setSearching(isSearching) {
        this.isSearching = isSearching;
        this.render();
    }
}

if (!customElements.get('search-input-lit')) {
    customElements.define('search-input-lit', SearchInputLit);
}

// Keep the template function for backward compatibility
export function searchInputTemplate(searchQuery, searchAddress, showResults, isSearching) {
    return html`
        <search-input-lit
            .searchQuery=${searchQuery}
            .showResults=${showResults}
            .isSearching=${isSearching}>
        </search-input-lit>
    `;
}

export function renderResult(res) {
    return {
        place_id: res.place_id,
        display_name: res.display_name
    };
}

export function selectSearchResult(res) {
    // placeholder for selection handling
}

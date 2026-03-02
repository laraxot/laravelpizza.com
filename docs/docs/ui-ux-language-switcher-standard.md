# UI/UX Standards: Language Switcher

Questo documento definisce gli standard UI/UX per il selettore di lingua nel progetto Laravel Pizza, basandosi sulle best practice del 2025.

## 🎯 Principi Fondamentali

### 1. Nomi Nativi (Autonimi)
Utilizzare sempre il nome della lingua come viene chiamato dai suoi parlanti nativi.
- ✅ `Deutsch` (non German)
- ✅ `Español` (non Spanish)
- ✅ `English`
- ✅ `Italiano`

### 2. Il Dilemma delle Bandiere
Le bandiere rappresentano nazioni, non lingue. 
- **Problema**: Lo spagnolo è parlato in Spagna, Messico, Argentina, ecc. Usare la bandiera spagnola può confondere o offendere utenti di altre nazioni.
- **Standard**: Preferire icone universali come il **Mondo (Globe)** o l'icona **Translate**. Le bandiere possono essere usate come "decorazione" secondaria solo se il target è molto specifico, ma non devono essere l'unico identificatore.

### 3. Accessibilità (A11y)
Il selettore deve essere navigabile da tutti:
- **ARIA**: Utilizzare `aria-label`, `aria-expanded`, `role="listbox"`, `role="option"`.
- **Keyboard**: Navigazione tramite `Tab` e selezione tramite `Enter`.
- **Focus**: Stati di focus ben visibili e contrastati.

### 4. Posizionamento
- **Header**: Angolo in alto a destra (standard de facto).
- **Footer**: Come fallback per una scoperta facile a fine pagina.
- **Mobile**: Facilmente accessibile nel menu hamburger o in una barra dedicata in alto.

---

## 🛠️ Implementazione Tecnica (Meetup Theme)

### Componente: `x-ui.language-switcher`

#### Trigger Button
Deve includere l'icona del mondo e il nome della lingua corrente (o il codice ISO).
```html
<button aria-haspopup="true" :aria-expanded="open" aria-label="Select Language">
    <x-filament::icon icon="heroicon-o-globe-alt" />
    <span>{{ $currentNativeName }}</span>
</button>
```

#### Dropdown Menu
Deve utilizzare le classi di transizione per un feeling premium.
```html
<div x-show="open" x-transition ... role="listbox">
    @foreach($locales as $code => $locale)
        <a role="option" :aria-selected="{{ $code === $currentLocale ? 'true' : 'false' }}">
            {{ $locale['native'] }}
        </a>
    @endforeach
</div>
```

## 🚀 Roadmap Miglioramenti
1. [ ] Aggiunta attributi ARIA completi.
2. [ ] Sostituzione icone bandiere con icona Globe come default visivo.
3. [ ] Miglioramento stati di focus in Dark Mode.
4. [ ] Implementazione "Language Discovery" (tooltip o banner se la lingua del browser differisce dalla corrente).

## 🛡️ Robustezza Tecnica

### 1. Sorgente di Verità (Source of Truth)
Non fare mai affidamento esclusivamente sui helper dei pacchetti (come `LaravelLocalization::getCurrentLocale()`) se si utilizza un sistema di routing non standard (come Laravel Folio).
- **Standard**: Utilizzare sempre `app()->getLocale()` per determinare la lingua attiva nel componente UI.
- **Perché**: `app()->getLocale()` è la sorgente di verità globale di Laravel. I pacchetti esterni potrebbero avere stati interni non sincronizzati se il middleware viene eseguito in un ordine imprevisto.

### 2. Sincronizzazione dello Stato
Se si registra la lingua manualmente (es. in un middleware di Folio), è obbligatorio sincronizzare anche il pacchetto di localizzazione:
```php
app()->setLocale($locale);
LaravelLocalization::setLocale($locale); // Sincronizzazione obbligatoria
```

### 3. Test di Stato Post-Refresh
Dopo ogni modifica al selettore di lingua, è obbligatorio verificare che:
1. Il refresh avvenga sulla URL corretta.
2. La label del componente (es. "English") si aggiorni correttamente e non resti bloccata sulla lingua di default.

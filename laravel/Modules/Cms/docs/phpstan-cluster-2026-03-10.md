# PHPStan Cluster - 2026-03-10

## Stato attuale

Dopo la riattivazione del run globale `./vendor/bin/phpstan analyse Modules`, il modulo `Cms` non e' piu' bloccato da errori sintattici ma da un cluster di contratti fuori sync.

## Root cause principali

### 1. View composer e component API divergenti

- `Modules\Cms\View\Composers\ThemeComposer` istanzia `Modules\UI\View\Components\Render\Blocks` con parametro `tpl`, ma il costruttore reale accetta `view`.
- `HeadernavData` espone `render()`, mentre il composer tenta `view()`.

Decisione applicativa:

- `HeadernavData` deve offrire `view()` come alias compatibile di `render()`, per restare allineato a `FooterData`.
- `ThemeComposer` deve passare `view: 'ui::components.render.blocks.v1'` al componente `Blocks`, non `tpl`.

### 2. Factory legacy riferita a modello non presente

- `database/factories/PostFactory.php` punta a `Modules\Cms\Models\Post`, ma nel modulo il modello non e' presente nello stato attuale del codice.
- Prima di forzare PHPStan con ignore o baseline, bisogna decidere se riallineare la factory a un modello reale o rimuovere il riferimento legacy.

### 3. Livewire payload tipizzato troppo ottimisticamente

- `Http\Livewire\Page\Show` assume proprieta' Eloquent non annotate (`subtitle`, `meta_description`, `meta_keywords`) e forza cast a string su valori che possono essere array/null.

## Regola operativa

- Prima correggere i contratti reali tra classi.
- Poi correggere le factory legacy o disaccoppiarle da modelli inesistenti.
- Solo dopo valutare eventuali affinamenti di PHPDoc.

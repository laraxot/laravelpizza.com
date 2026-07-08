## Reactive binding con wire:model e Filament Input

### Contesto
Nella pagina `resources/views/admin/condizioni_lavoro/compila/page.blade.php` sono presenti campi numerici resi con `<x-filament::input>` e binding Livewire tramite `wire:model` verso la struttura annidata `form_data.dettaglio.{id}.pivot.gg`.

### Problema riscontrato
Modificando il valore dell'input, l'output di debug mostrato tramite `print_r($form_data['dettaglio'][$id]['pivot'])` non risultava aggiornato come atteso.

### Cause tecniche verificate
- Livewire v3 usa come comportamento predefinito `wire:model.defer` (aggiornamento differito): gli aggiornamenti non vengono inviati al server ad ogni battitura, ma solo in momenti specifici (es. submit, blur), a meno che non si usino i modificatori `.live`/`.blur`/`.debounce`.
- In un loop, l'assenza di `wire:key` può causare problemi di riconciliazione del DOM, impedendo il corretto aggiornamento del nodo giusto (specialmente quando gli indici cambiano o sono numerici).
- L'uso di `print_r()` dentro `{{ ... }}` stampa i dati e ritorna `1`, con il rischio di avere un output confuso. Inoltre, non è formattato e può essere meno leggibile; è preferibile usare `json_encode()` con `JSON_PRETTY_PRINT` in un `<pre>`.

Questi punti spiegano perché il valore non appariva aggiornato immediatamente o coerentemente nel blocco di debug.

### Correzioni implementate
1. Aggiunta di `wire:key` alla riga del loop per stabilizzare il diff del DOM:
   ```blade
   <tr class="border border-gray-400" wire:key="dettaglio-{{ $dettaglio->id }}">
   ```

2. Passaggio da `wire:model` a `wire:model.live.number` sull'`<x-filament::input>` numerico per aggiornamenti immediati (e cast numerico) durante la digitazione:
   ```blade
   <x-filament::input
       type="number"
       wire:model.live.number="form_data.dettaglio.{{ $dettaglio->id }}.pivot.gg"
   />
   ```

3. Sostituzione del `print_r()` con una rappresentazione JSON leggibile e sicura:
   ```blade
   <pre class="whitespace-pre-wrap">{{ json_encode($form_data['dettaglio'][$dettaglio->id]['pivot'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
   ```

### Fonti e riferimenti
- Filament – Input component: https://filamentphp.com/docs/4.x/components/input
- Filament – Input wrapper: https://filamentphp.com/docs/4.x/components/input-wrapper
- Livewire (v3) – Data binding e modifiers (wire:model, .live/.blur/.debounce/.number): https://livewire.laravel.com/docs/properties

Note: I componenti Filament propagano gli attributi al campo `<input>` sottostante, quindi `wire:model.*` su `<x-filament::input>` è supportato.

### Verifica
- Digitando nel campo con `wire:model.live.number`, il JSON di debug si aggiorna immediatamente al successivo render Livewire.
- Con `wire:key` per riga, l’aggiornamento rimane stabile anche con più elementi.

### Impatti
- Migliore coerenza tra valore digitato e stato server-side.
- Debug più leggibile e privo dell’effetto collaterale di `print_r()`.





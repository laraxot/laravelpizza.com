# Events Detail Component - Volt Class Pattern

## 🎯 Principio: unica fonte di verità = Event

Il componente `events/detail.blade.php` è un **Volt component** quando il blocco ha `"livewire": "events.detail"`. La logica: **il modello Event è l’unica fonte di verità**. In `mount()` si risolve l’istanza (da `event ?? item ?? slug0`) e si **popolano proprietà pubbliche** per la vista (title, date, location, status, badgeClass, eventsUrl, ecc.). La vista usa solo `$this->title`, `$this->date`, ecc. — **niente** array `eventData[]` o computed che ricalcolano dall’Event.

Vedi: [Volt Components Usage](volt-components-usage.md) — regola "unica fonte di verità = modello".

## ⚠️ Quando usare Volt vs Filament Widget

Per **presentazione** (dettaglio evento, lista): Volt con mount() e proprietà pubbliche. Per **interattività** (form, submit, azioni server-side): **Filament Widgets** (extends XotBaseWidget).

Vedi: [Filament Widgets NOT Livewire Critical Rule](filament-widgets-not-livewire-critical-rule.md)

## Pattern Volt (events.detail)

- Input: `event`, `item`, `container0`, `slug0`.
- In `mount()`: `$eventModel = $this->event ?? $this->item ?? Event::where('slug', $this->slug0)->first()`. Se `$eventModel instanceof Event`, assegna a proprietà pubbliche: `title`, `slug`, `description`, `date`, `time`, `location`, `attendeesCurrent`, `attendeesMax`, `coverImage`, `availableSpots`, `status`, `statusLabel`, `badgeClass`; imposta `eventsUrl`. Valori di default nelle proprietà per il caso senza Event.
- `eventModel` si tiene solo per Schema.org in `@push('meta')`.
- Vista: usa solo `$this->title`, `$this->date`, ecc. — niente `eventData[]` o computed.

## Riferimenti

- [Volt Components Usage](volt-components-usage.md)
- [Filament Widgets NOT Livewire Critical Rule](filament-widgets-not-livewire-critical-rule.md)
- [Events Detail Slug0 Loading](events-detail-slug0-loading.md)
- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)

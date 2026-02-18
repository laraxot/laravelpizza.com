# Events Detail Component - Volt Class-Inspired Pattern

## 🎯 Principio: Organizzazione Codice con Helper Class

Il componente `events/detail.blade.php` utilizza un pattern ispirato a Volt Class API per migliorare l'organizzazione del codice, la manutenibilità e la testabilità, mantenendo la compatibilità con il sistema CMS che include il componente tramite `@include`.

Vedi anche: [Themes/Meetup/docs/events-detail-volt-class-pattern.md](../../Themes/Meetup/docs/events-detail-volt-class-pattern.md)

## 📜 Pattern: Helper Class invece di Volt Class

### Perché Helper Class invece di Volt Class?

Il componente viene incluso tramite `@include` da `page-content.blade.php`, quindi non è un componente Livewire standalone. Per questo motivo:

- ❌ **NON possiamo usare Volt Class API direttamente** (richiede componente Livewire)
- ✅ **Usiamo una Helper Class PHP** che segue lo stesso pattern organizzativo
- ✅ **Mantiene compatibilità** con `@include` del sistema CMS
- ✅ **Migliora organizzazione** del codice rispetto a blocchi `@php` inline

## 🔗 Riferimenti

- [Events Detail Slug0 Loading](events-detail-slug0-loading.md)
- [Volt Class API Documentation](https://livewire.laravel.com/docs/volt)
- [Container0 Slug0 Agnostic Pattern](../Themes/Meetup/docs/container0-slug0-agnostic-pattern.md)
- [CMS JSON Content System](../Cms/docs/json-content-system-architecture.md)

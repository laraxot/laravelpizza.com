<?php

declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['guest']);
name('register');

?>

{{--
  Ripiego del modulo: un tema che ha `pages/auth/register.blade.php` la
  sostituisce, perche' Folio preferisce le viste del tema.

  E' lo stesso trattamento che ha la pagina gemella del login, accanto a questa,
  e per la stessa ragione — ma qui mancava, e la differenza si vedeva:

      /{lingua}/auth/login      200
      /{lingua}/auth/register   500   InvalidArgumentException:
                                      No hint path defined for [pub_theme]

  Qui c'era un `@include('pub_theme::components.pages.auth-register')` nudo. Il
  namespace `pub_theme` lo registra `CmsServiceProvider::boot()` **solo** se
  `xra.register_pub_theme` e' vero, e per il tenant `localhost` e' falso: un
  `@include` di un namespace non registrato non ripiega, lancia. Risultato, in
  ogni progetto senza quel flag e senza pagina del tema: **non si poteva
  registrare nessuno**, e al posto del modulo d'iscrizione arrivava circa un
  megabyte di pagina d'errore (base_quaeris_fila5#237).

  `view()->exists()` sul namespace non registrato non lancia — `Factory::exists()`
  cattura l'`InvalidArgumentException` del finder e restituisce `false` — quindi
  il controllo si puo' fare proprio sul caso che prima faceva cadere la pagina.

  Il widget montato nel ripiego e' quello di **questo** modulo, non quello di
  Gdpr: un modulo condiviso non puo' dipendere da un modulo che potrebbe non
  essere installato. Il rovescio della medaglia e' scritto nella vista di questo
  widget: e' il ripiego **senza consensi**. Un progetto che raccoglie consensi
  mette la propria pagina nel tema e monta
  `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget` — come fa
  `Themes/Zero/resources/views/pages/auth/register.blade.php` in
  base_quaeris_fila5. La divisione delle responsabilita' sta in
  `Modules/Gdpr/docs/register-widget-copy-ownership.md`.
--}}
{{--
  `auth_pages.register.page.title` e non `auth.register.title`: la seconda e' un
  **array** (`key`, `label`, `text`, `description`, ...), e `__()` di una chiave
  di gruppo restituisce l'array — che concatenato da' «Array to string
  conversion». Serve una chiave foglia.
--}}
<x-layouts.app :title="__('user::auth_pages.register.page.title')">
    @if (view()->exists('pub_theme::components.pages.auth-register'))
        @include('pub_theme::components.pages.auth-register')
    @else
        <div class="mx-auto max-w-md px-4 py-12">
            @livewire(\Modules\User\Filament\Widgets\Auth\RegisterWidget::class)
        </div>
    @endif
</x-layouts.app>

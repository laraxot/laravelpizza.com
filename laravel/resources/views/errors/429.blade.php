{{-- Pagina 429 del tema pubblico (Themes/<Tema>/resources/views/errors/page.blade.php); senza tema, la pagina autonoma. --}}
@include(view()->exists('pub_theme::errors.page') ? 'pub_theme::errors.page' : 'errors.fallback', ['code' => 429])

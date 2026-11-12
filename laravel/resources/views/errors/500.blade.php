{{-- Pagina 500 autonoma: niente database né sessione, funziona anche quando il guasto è lì. --}}
@include('errors.fallback', ['code' => 500])

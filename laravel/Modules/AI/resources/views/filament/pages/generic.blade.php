{{--
    Vista di ripiego delle pagine Xot senza una vista propria (XotBasePage::getView): mostra i widget della pagina
    (lo fa il layout) e i suoi form. Prima una pagina senza vista dava errore 500.
--}}
<x-filament-panels::page>
    @foreach ($this->getGenericViewSchemas() as $schema)
        {{ $schema }}
    @endforeach
</x-filament-panels::page>

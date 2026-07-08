nds('adm_theme::layouts.app')
@section('page_heading', 'package sigma')
@section('section')
    <x-filament::badge> flash-message </x-filament::badge>


    Sigma package ..
    {{ get_class($_panel) }}
    {{-- @foreach ($_panel->containerActions() as $act)
        {!!  $act->btnHtml() !!}
    @endforeach --}}

@endsection

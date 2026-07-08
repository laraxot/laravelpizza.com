nds('adm_theme::layouts.app')
@section('page_heading','Estrazioni')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{{ Form::open(['route'=>['estrazioni.update',1]]) }}
@csfr
@method('put');
{{ Form::bsText('ente',90) }}
{{ Form::bsDate('data') }}
{{ Form::bsSubmit('save') }}
{{ Form::close('') }}


@endsection

nds('adm_theme::layouts.app')
@section('page_heading','Estrazioni')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{{ Form::open(['route'=>['estrazioni.update',2]]) }}
@csfr
@method('put');
{{ Form::bsText('anno') }}
{{ Form::bsSubmit('vai') }}
{{ Form::close('') }}
@endsection

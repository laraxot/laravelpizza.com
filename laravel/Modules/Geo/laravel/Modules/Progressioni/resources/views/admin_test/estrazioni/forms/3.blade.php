nds('adm_theme::layouts.app')
@section('page_heading','Estrazioni')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{{ Form::open(['route'=>['estrazioni.update',3]]) }}
@csfr
@method('put');
{{ Form::bsText('anno',date('Y')) }}
<p>se selezioni il checkbox i dati vengono ricreati, assicurarsi che le tabelle sigma siano aggiornate o si sbarella</p>
{{ Form::bsCheckbox('update') }}

{{ Form::bsSubmit('vai') }}
{{ Form::close('') }}
@endsection

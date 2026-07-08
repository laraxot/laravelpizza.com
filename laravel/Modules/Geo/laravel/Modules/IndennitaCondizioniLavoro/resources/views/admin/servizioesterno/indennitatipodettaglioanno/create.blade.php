nds('adm_theme::layouts.app')
@section('page_heading','Servizio Esterno')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


{!! Form::bsOpen($row,'store') !!}
{{ Form::bsSelect('indennita_tipo_id',null,['options'=>$row->indennita_tipo_opts]) }}
{{ Form::bsTextarea('nome') }}
{{ Form::bsText('dal') }}
{{ Form::bsText('al') }}
{{ Form::bsDecimal('euro_giorno') }}
{{ Form::bsSubmit('modifica!') }}
{{ Form::close() }}
@endsection

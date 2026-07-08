nds('adm_theme::layouts.app')
@section('page_heading','Servizio Esterno')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

<a href="{{ route('indennita.servizioesterno.anno.indennitatipodettaglioanno.index',$params) }}" class="btn btn-default">&laquo;&nbsp; Back</a>

{!! Form::bsOpen($row,'update') !!}
{{--
{{ Form::bsSelect('indennita_tipo_id',null,) }}
--}}
<h3 style="color:navy">{{ $row->indennitaTipo->nome }}</h3>
{{ Form::bsTextarea('nome') }}
{{ Form::bsText('dal') }}
{{ Form::bsText('al') }}
{{ Form::bsDecimal('euro_giorno') }}
{{ Form::bsText('only_disci1') }}
{{ Form::bsText('only_codqua') }}
{{ Form::bsText('except_disci1') }}
{{ Form::bsText('except_codqua') }}

{{ Form::bsSubmit('modifica!') }}
{{ Form::close() }}
@endsection

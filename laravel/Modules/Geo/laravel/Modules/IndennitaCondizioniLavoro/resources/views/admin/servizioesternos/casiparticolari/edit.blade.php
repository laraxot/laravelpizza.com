nds('adm_theme::layouts.app')
@section('page_heading','Casi Particolari')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

<a href="{{ route('indennita.servizioesterno.anno.casiparticolari.index',$params) }}" class="btn btn-primary">&laquo;&nbsp; Back </a>

{!! Form::bsOpen($row,'update') !!}
{{-- Form::bsSelect('indennita_tipo_id',null,['options'=>$row->indennita_tipo_opts]) --}}
{{ Form::bsText('ente') }}
{{ Form::bsText('matr') }}
{{ Form::bsText('anno') }}
{{ Form::bsSelect('status',null,['options'=>$row->all_status]) }}
{{ Form::bsTextarea('note') }}
{{ Form::bsSubmit('modifica!') }}
{{ Form::close() }}
@endsection

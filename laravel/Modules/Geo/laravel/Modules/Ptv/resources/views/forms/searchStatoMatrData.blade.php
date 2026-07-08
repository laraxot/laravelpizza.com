nds('adm_theme::layouts.app')
@section('page_heading','cerca')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


{{  Form::open(['route' => Request::route()->getName(),'method'=>'GET' ]) }}
{{-- method_field('get') --}}
{{-- csrf_field() --}}
{{ Form::bsText('ente') }}
{{ Form::bsText('matr') }}

{{-- Form::bsText('giorno') --}}
{{ Form::bsText('mese') }}
{{ Form::bsText('anno') }}
{{ Form::bsSubmit('vai') }}


{!! Form::close() !!}
@endsection

nds('adm_theme::layouts.app')
@section('content')
    @php

    //dddx(get_defined_vars());
    @endphp
    {{-- {!! Panel::make()->get($row)->url('index') !!} <br/>
{!! $_panel->url('index') !!} --}}

    <a href="{{ $_panel->url('index') }}" class="btn btn-primary">&laquo; Torna alla lista </a>

    {!! Form::model($row, ['url' => Request::fullUrl()]) !!}
    @method('post')

    {{ Form::bsSelect2Sides('mails',null,get_defined_vars()) }}
    {{ Form::bsSubmit('manda mail') }}
    {{ Form::close() }}

    @include($view.'.report')
@endsection

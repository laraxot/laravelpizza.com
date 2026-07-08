nds('adm_theme::layouts.app')
@section('content')
    @php
    //dddx($row);
    //dddx(get_defined_vars());
    @endphp
    <a href="{{ Panel::make()->get($row)->url('index') }}" class="btn btn-primary">&laquo; Torna alla lista </a>

    {!! Form::bsOpen($row, 'store') !!}

    {{ Form::bsSelect2Sides('mails', null, get_defined_vars()) }}
    {{ Form::bsSubmit('manda mail') }}
    {{ Form::close() }}


    @include($view.'.report')


@endsection

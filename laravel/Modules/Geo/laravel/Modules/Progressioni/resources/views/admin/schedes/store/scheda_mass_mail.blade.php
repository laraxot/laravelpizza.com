nds('adm_theme::layouts.app')
@section('content')
    @php
    //dddx($row);
    //dddx(get_defined_vars());
    @endphp
    {!! Form::bsOpen($row, 'store') !!}

    {{ Form::bsSelect2Sides('mails', null, get_defined_vars()) }}
    {{ Form::bsSubmit('manda mail') }}
    {{ Form::close() }}

@endsection

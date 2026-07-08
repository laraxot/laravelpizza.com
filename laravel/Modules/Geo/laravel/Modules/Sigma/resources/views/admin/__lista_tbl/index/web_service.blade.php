nds('adm_theme::layouts.app')
@section('content')
{!! Form::model($row,['url'=>Request::fullUrl() ]) !!}
    @method('POST')
    <ul>
    @foreach($tbls as $tbl)
        <li>{!! Form::checkbox('tbls[]', $tbl, null, []) !!} {{ $tbl }}</li>
    @endforeach
    </ul>
    {!! Form::bsSubmit() !!}
{!! Form::close() !!}
@endsection

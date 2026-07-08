nds('pub_theme::layouts.app')
@section('content')

{!! Form::model($row,['url'=>Request::fullUrl(),'files'=>'true' ]) !!}
@method('POST')

    {{ Form::bsText('tbl_name') }}
    {{ Form::bsString('field_delimiter',';') }}
    {{ Form::bsString('row_delimiter','/r/n') }}
	{{ Form::bsUpload('file_zip') }}
	{{ Form::bsSubmit('files to table') }}
	{{ Form::close() }}
@endsection

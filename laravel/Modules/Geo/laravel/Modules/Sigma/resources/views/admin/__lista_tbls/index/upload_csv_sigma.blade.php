nds('adm_theme::layouts.app')
@section('content')
	{!! Form::bsOpen($row,'store') !!}
	{{ Form::bsText('tbl_name') }}
	{{ Form::bsUploadCsv('file_txtd') }}
	{{ Form::bsUploadCsv('file_csv') }}
	{{ Form::bsSubmit('files to table') }}
	{{ Form::close() }}
@endsection
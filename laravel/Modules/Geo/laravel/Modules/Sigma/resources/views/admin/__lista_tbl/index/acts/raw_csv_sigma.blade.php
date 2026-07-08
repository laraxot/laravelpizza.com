nds('adm_theme::layouts.app')
@section('content')
	{!! Form::bsOpen($row,'store') !!}
	{{ Form::bsText('tbl_name') }}
	{{ Form::bsText('csv_path') }}
	{{ Form::bsSubmit('raw query') }}
	{{ Form::close() }}
@endsection
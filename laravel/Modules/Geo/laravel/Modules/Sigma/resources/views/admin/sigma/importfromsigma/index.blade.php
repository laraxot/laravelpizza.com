nds('adm_theme::layouts.app')
@section('page_heading','package sigma')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{!! Form::bsFormSearch() !!}


<table class="table table-hover table-condensed table-responsive table-striped">
<thead>
	<tr>
		<td>ID</td>
		<td>DB.TBL</td>
		<td></td>
	</tr>
</thead>
@foreach($rows as $row)
<tr>
	<td>{{ $row->id }}</td>
	<td>{{ $row->db }}.{{ $row->tbl }}</td>
	<td>{!! Form::bsBtnEdit(['id_importFromSigma'=>$row->id]) !!}</td>
</tr>
@endforeach
</table>
{{ $rows->links() }}
@endsection

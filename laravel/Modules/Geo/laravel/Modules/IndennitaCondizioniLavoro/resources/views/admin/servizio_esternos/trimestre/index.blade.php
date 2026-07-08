nds('adm_theme::layouts.app')
@section('page_heading','indennita')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

@php
	$day_start=Carbon\Carbon::create($anno,1,1,0,0,0);
	$day_end=Carbon\Carbon::create($anno,1,1,0,0,0)->addMonths(3);
@endphp

<table>
	<thead>
		<tr>
			<td>ID</td>
			<td>dal</td>
			<td>al</td>
		</tr>
	</thead>
	@for($i=1;$i<=4;$i++)
	<tr>
		<td>{{ $i }}</td>
		<td>{{ $day_start->format('d/m/Y') }}</td>
		<td>{{ $day_end->subDay()->format('d/m/Y') }}</td>
	</tr>
	@php
		$day_start->addMonths(3);
		$day_end->addDay();
		$day_end->addMonths(3);
	@endphp
	@endfor
</table>

@endsection

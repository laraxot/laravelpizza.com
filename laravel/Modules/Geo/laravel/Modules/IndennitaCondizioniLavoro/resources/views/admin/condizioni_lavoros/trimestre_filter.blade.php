nds('adm_theme::layouts.app')
@section('page_heading','indennita Condizioni Lavoro')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


<ul>
@for($i=1;$i<=4;$i++)
	<li>
		<a href="?trimestre={{ $i }}">
			<i class="far fa-file-pdf fa-2x"></i> {{ $i }} Trimestre {{ $anno }}
		</a>
	</li>
@endfor
</ul>

@endsection

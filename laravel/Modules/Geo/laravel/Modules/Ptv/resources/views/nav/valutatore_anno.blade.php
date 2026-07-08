aria-label="month year navigation">
<form method="get">
  	<ul class="pagination justify-content-center">
  		<li>
			{{ Form::bsSelect('valutatore_id',request('valutatore_id'),
  				['options'=>$valutatori_opts] )
  			}}
		  {{--
		  @php
			  $field=[
					'name'=>'valutatore_id',
					'type'=>'select',
					'options'=>$valutatori_opts,
			  ];
		  @endphp
		  <x-theme::input_lw :props="$field"> </x-theme::input_lw>

			<x-theme::input name="valutatore_id" type="select" :options="$valutatori_opts" :value="request('valutatore_id')"> </x-theme::input>
			--}}
		</li>
		<li>
			{{ Form::bsText('year',date('Y')) }}
		<li>
		<li>
			<br/>
			<button type="submit" class="btn btn-info">
				<i class="fas fa-filter"></i>
			</button>
		</li>
	</ul>
</form>
</nav>
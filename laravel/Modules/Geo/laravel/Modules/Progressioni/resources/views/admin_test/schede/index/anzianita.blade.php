e class="table table-striped table-bordered ">
	<thead>
		<tr>
		<td>descr</td>
		<td>q</td>
		<td>peso</td>
		<td></td>
		</tr>
	</thead>
	<tbody>
	@php
		$tot=0;
	@endphp
	@foreach($row->coeff()->get() as $kc=>$vc)
		@php
			$sk=$vc->name;
		@endphp
		@if($vc->value!=0)
		<tr>
			<td>{{ str_replace('_','_',$vc->name) }}</td>
			<td align="right">{{ number_format($row->$sk,2) }}</td>
			<td align="right">{{ number_format($vc->value,2) }}</td>
			@php
				$curr=$row->$sk*$vc->value;
				$tot+=$curr;
			@endphp
			<td align="right">

				@php
					$routename=str_replace('.index', '.'.$vc->name, Request::route()->getName());
					$params=getRouteParameters();
					$params['matr']=$v->matr;
					$route=route($routename, $params);
				@endphp
				<a href="{{ $route }}">{{ number_format($curr,2) }}</a>
			</td>
		</tr>
		@endif
	@endforeach
	<tr><td colspan="3"><b>Tot</b></td><td align="right"><b>{{ number_format($row->gg_tot_pond,2) }} {{-- number_format($tot,2) --}}</b></td></tr>
	</tbody>
</table>

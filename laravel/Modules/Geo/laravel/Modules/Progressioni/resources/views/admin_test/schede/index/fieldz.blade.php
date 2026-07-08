e class="table table-striped table-bordered">
	@foreach($fieldz as $field)
	<tr>
		<td>{{ $field }}:</td>
		<td align="right">
			<?php
            $routename = str_replace('.index', '.'.$field, (string) Request::route()->getName());
			$params = getRouteParameters();
			$params['matr'] = $v->matr;
			$route = route($routename, $params);
			?>
			<a href="{{ $route }}">{{ $v->$field }}</a>
		</td>
	</tr>
	@endforeach
</table>

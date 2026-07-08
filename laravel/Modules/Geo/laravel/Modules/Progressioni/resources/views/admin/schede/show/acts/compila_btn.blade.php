$scheda_criteri=$row->schedaCriteri;
@endphp
<table class="table">
	{{--
@foreach($scheda_criteri as $k=>$v)
	<tr>
		<td>{{ $v->descr }}</td>
		<td align="right">{{ round($v->peso,2) }}</td>
		<td>{{ $row->{$v->field_name} }}</td>
	</tr>
@endforeach
--}}
<tr>
	<td colspan="3">
		<a href="{{ $url }}" class="btn btn-success">
			<i class="fas fa-file-signature"></i>&nbsp;Compila
		</a>
	</td>
</tr>
</table>

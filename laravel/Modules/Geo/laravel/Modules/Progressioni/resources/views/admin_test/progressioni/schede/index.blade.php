pdf)
	<?php $lay = 'pdf'; ?>
@else
	<?php $lay = 'dashboard'; ?>
@endif

@extends('adm_theme::'.'.layouts.'.$lay)

@section('page_heading','Lista Scheda')
@section('section')
!!!!!!!!!!!!!!!!
@if(!$pdf)
<a class="btn btn-default" href="{{ route('progressioni.schede.search') }}"><i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp; Torna alla ricerca..</a>
<a href="?PDF=1" target="_blank">PDF1</a>
@endif
<table class="table table-striped table-bordered " >
 <col style="width: 15%" class="col1" />
 <col style="width: 15%" />
 <col style="width: 15%" />
 <col style="width: 15%" />
 <col style="width: 15%" />
 <col style="width: 15%" />

@foreach($rows as $k => $v)
<tr>
<td>
	[{{ $v->id }}]
	<br/>{{ $v->cognome }}<br/>{{ $v->nome }}
	<br>{{ $v->dal }} - {{ $v->al }}
</td>
<td>
	{{ $v->propro }}-{{ $v->posfun }}
	<br/>{{ $v->categoria_eco }}
	<br/>{{ $v->qua2kd }} - {{ $v->qua2ka }}
</td>
<td>
	{{ $v->stabi }}-{{ $v->repar }}
	<br/>{{ $v->stabi_txt }}
	<br/>{{ $v->repar_txt }}
	<br/>{{ $v->rep2kd }} - {{ $v->rep2ka }}
</td>
<td>
	{{ $v->posiz }}
	<br/>{{ $v->posiz_txt }}
</td>
<td>
	<table class="table table-striped table-bordered">
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
</td>
<td>
@if($v->ha_diritto)
<table class="table table-striped table-bordered ">
<thead>
	<tr>
	<td>criterio</td>
	<td>valore</td>
	<td>peso</td>
	</tr>
</thead>
@foreach($valutaz_fields as $kv => $vv)
<tr>
	<td>{!! str_replace('_','<br/>',$vv) !!}</td>
	<td>{{ $v->$vv }}</td>
	<?php $skv = 'peso_'.$vv;
	?>
	<td>{{ $v->skv }}</td>
</tr>
@endforeach



</table>
@else
NO
@endif

{{ $v->motivo }}
</td>

</tr>
@endforeach
</table>

@endsection

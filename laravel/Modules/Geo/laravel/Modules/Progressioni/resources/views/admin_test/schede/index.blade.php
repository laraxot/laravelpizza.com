	$pdf=0;
@endphp
@if($pdf)
	<?php $lay = 'pdf'; ?>
@else
	<?php $lay = 'dashboard'; ?>
@endif

@extends('adm_theme::'.'.layouts.'.$lay)

@section('page_heading','Lista Scheda')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


@if(!$pdf){{-- route('progressioni.schede.search') --}}
@include($view.'.nav')
@include($view.'.firma')
{{--
<a href="?PDF=1" target="_blank">PDF2</a>
--}}
@endif
<table class="table table-striped table-bordered " >
 <col style="width: 15%" class="col1" />
 <col style="width: 15%" />
 <col style="width: 15%" />
 <col style="width: 15%" />
 <col style="width: 15%" />
 <col style="width: 15%" />

@foreach($rows as $k => $v)
@if($v->ha_diritto)
<tr>
	<td>
		[{{ $v->id }}]
		<br/>{{ $v->matr }}
		<br/><span style="color:navy;font-weight:650">{{ $v->cognome }} {{ $v->nome }} </span>
		<br/>email: {{ $v->email }}
		<br/>{{ $v->dal }} - {{ $v->al }}
	</td>
	<td>
		{{ $v->propro }}-{{ $v->posfun }}
		<br/>{{ $v->categoria_eco }}
		<br/>{{ $v->qua2kd }} - {{ $v->qua2ka }}
	<hr/>
		{{ $v->stabi }}-{{ $v->repar }}
		<br/>{{ $v->stabi_txt }}
		<br/>{{ $v->repar_txt }}
		<br/>{{ $v->rep2kd }} - {{ $v->rep2ka }}
	<hr/>
		{{ $v->posiz }}
		<br/>{{ $v->posiz_txt }}
	</td>
	{{--
	<td>
		@include($view.'.anzianita',['row'=>$v])
	</td>
	--}}
	<td>
	@if($v->ha_diritto)
		@include($view.'.valutazione',['row'=>$v])
		@php
			$routepdf=str_replace('.index','.pdfrow',$routename);
			$parz=$params;
			$parz['id_pdf']=$v->id;
			$routepdf=route($routepdf,$parz);
		@endphp
		{{--
		<a class="btn btn-small btn-default" data-toggle="tooltip" title="Crea PDF riepilogo" href="{{ $routepdf }}"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i>&nbsp;</a>
		--}}
	@else
	NO
	@endif

	{{ $v->motivo }}
	</td>
</tr>
@endif
@endforeach
</table>
{{$rows->links()}}
@endsection

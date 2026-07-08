nds('adm_theme::layouts.app')
@section('page_heading','Criteri Esclusione')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{!! Form::bsBtnCreate() !!}

<table class="table table-striped table-bordered">
<thead>
<tr>
	<td>ID</td>
	<td>min gg posiz_1 in sede</td>
	<td>min gg propro</td>
	<td>min gg propro posfun</td>
	<td>min gg cateco posfun lavorati solo in sede</td>
	<td>min gg anno</td>
	<td>lista propro posfun</td>
	<td>lista propro </td>
	<td>lista posiz</td>
	<td>lista codici assenza subito esclusione (es sanzioni)</td>
	<td>giorni controllo codici assenza subito esclusione</td>
	<td>disci</td>
	<td>presenti il giorno</td>
	<td>data presenza al</td>
	<td>data presenza dal</td>
	<td>anno</td>
	<td></td>
</tr>
</thead>
<tbody>
@foreach($rows as $k =>$v)
<tr>
	<td>{{ $v->id }}</td>
	<td>{{ $v->min_gg_posiz_1_in_sede }}</td>
	<td>{{ $v->min_gg_propro }}</td>
	<td>{{ $v->min_gg_propro_posfun }}</td>
	<td>{{ $v->min_gg_cateco_posfun_lavorati_in_sede }} </td>
	<td>{{ $v->min_gg_anno }}</td>
	<td>{{ $v->lista_propro_posfun }}</td>
	<td>{{ $v->lista_propro }}</td>
	<td>{{ $v->lista_posiz }}</td>
	<td>{{ $v->lista_asz_tip_cod_escluso_subito }}
	<td>{{ $v->min_gg_asz_tip_cod_escluso_subito }}
	<td>{{ $v->disci }}</td>
	<td>
		@if($v->presenti_il_giorno!=null)
		{{ $v->presenti_il_giorno->formatLocalized('%d/%m/%Y') }}
		@endif
	</td>
	<td>
		@if($v->data_presenza_al!=null)
		{{ $v->data_presenza_al->formatLocalized('%d/%m/%Y') }}
		@endif
	</td>
	<td>
		@if($v->data_presenza_dal!=null)
		{{ $v->data_presenza_dal->formatLocalized('%d/%m/%Y') }}
		@endif
	</td>
	<td>{{ $v->anno }}</td>
	<td>[<i class="fas fa-edit"></i>][<i class="fas fa-trash-alt"></i>][<i class="far fa-clone"></i>]
		{!! Form::bsBtnCrud(['row'=>$v]) !!}
		{!! Form::bsBtnClone(['row'=>$v]) !!}
		{{--
		{!! Form::bsBtnCrud(['id_criteriesclusione'=>$v->id]) !!}
		{!! Form::bsBtnClone(['id_criteriesclusione'=>$v->id]) !!}
		--}}
		<a class="btn " href="{{ route('progressioni.criteriesclusione.updateesclusi',$v->id) }}">
			<i class="fas fa-magic"></i>Aggiorna Esclusi
		</a>
	</td>
</tr>
</tbody>
@endforeach

</table>
{{$rows->links()}}
@endsection

le>
	<thead>
		<tr>
			<th>ID</th>
			<th>Dettaglio</th>
			<th>Giorni</th>
			<th>Percentuale</th>
			<th>Valore</th>
		</tr>
	</thead>
	{{--
	@if($row->dettaglio != null)
	@foreach($row->dettaglio as $subt)
	--}}
	@if($dettagli != null)
	@foreach($dettagli as $subt)
	<tr>
		@php
			$val=$parent->indennitaTipoDettaglio->where('id',$subt->id)->first(); // valori salvati pivot
			$val1=$parent->indennita_tipo_dettaglio_all->where('id',$subt->id)->first(); //valori tabella
			$euro_giorno=$val1->euro_giorno;
			$gg=0;
			$note='';
			if(isset($val->pivot) ){
				$gg=$val->pivot->gg;
				$note=$val->pivot->note;
			}
		@endphp
		{{--  <td>{{ utf8_decode($subt->nome) }}</td> --}}
		<td width="50">{{ $subt->id }}</td>
		<td >{{ $subt->nome }}</td>
		<td width="200">{{ Form::bsText('gg['.$subt->id.']',$gg,['label'=>' ','data-id'=>$subt->id,'size'=>5]) }}
			{{--
			<br/><br/>
			{{ Form::bsTextarea('note['.$subt->id.']',$note,['label'=>'']) }}
			--}}
		</td>
		<td width="100" align="right">
			<div id='perc_{{ $subt->id }}'>00</div>
		</td>
		<td width="100" align="right">
			<div style="display:none">
				<div id='euro_giorno_{{ $subt->id }}'>{{ $euro_giorno }}</div>
			</div>
			<div id='soldi_{{ $subt->id }}'>00</div>
		</td>

	</tr>
	@endforeach
	@endif
</table>
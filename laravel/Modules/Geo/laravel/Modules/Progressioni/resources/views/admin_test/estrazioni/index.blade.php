nds('adm_theme::layouts.app')
@section('page_heading','Estrazioni')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


<h3>giorni ultima categoria economica + assenze
	<a href="{{ route('estrazioni.edit',1) }}" class="btn btn-default">
		<i class="fa fa-magic"></i>
	</a>
</h3>
<h3>Xls senza operazioni di aggiornamento sui campi
	<ul>
		<li>Aggiornamento aventi diritto su <a href="{{ route('progressioni.criteriesclusione.index') }}">Progressioni Admin &raquo; Criteri Esclusione</a></li>
		<li>Aggiornamento campi su <a href="{{ route('progressioni.updateFieldForm') }}">Progressioni Admin &raquo; updateField</a></li>
	</ul>
	<a href="{{ route('estrazioni.edit',2) }}" class="btn btn-default">
		<i class="fa fa-magic"></i>
	</a>
</h3>
{{--  --}}
<h3>
	Xls solo campi coeff
	<a href="{{ route('estrazioni.edit',3) }}" class="btn btn-default">
		<i class="fa fa-magic"></i>
	</a>
</h3>


@endsection

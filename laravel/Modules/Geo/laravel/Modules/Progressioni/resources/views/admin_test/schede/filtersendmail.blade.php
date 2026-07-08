nds('adm_theme::layouts.app')
@section('page_heading','Filtro invio mail')

@section('section')
<x-filament::badge> flash-message </x-filament::badge>

{{--
<div id="wrap" class="container">
--}}
@php
    $routename=\Route::currentRouteName();
    $routename_prev=str_replace('.filtersendmail','.index',$routename);
@endphp


<a class="btn btn-small btn-info"  data-toggle="tooltip" title="Torna alla ricerca" href="{{  route($routename_prev,$params) }}"><i class="fa fa-step-backward fa-fw" aria-hidden="true"></i>&nbsp;</a>

@php
$routename=Request::route()->getName();
$params=array_merge([$routename],getRouteParameters());
$route=route($routename,$params);
if(!isset($rows)){
	$rows=[];
}

@endphp



{{ Form::open() }}
{{  method_field('POST') }}
<div class="row">
    <div class="col-sm-5">
        <select name="from[]" id="multiselect" class="form-control" size="8" multiple="multiple">
        	{{--
            <option value="1" data-position="1">Item 1</option>
            <option value="2" data-position="2">Item 5</option>
            <option value="2" data-position="3">Item 2</option>
            <option value="2" data-position="4">Item 4</option>
            <option value="3" data-position="5">Item 3</option>
            --}}
            @foreach($rows as $v)
            <option value="{{ $v->id }}" >{{ $v->id }}] {{ $v->matr }} {{ $v->cognome }} {{ $v->nome }} {{ $v->email }} </option>
            @endforeach
        </select>
    </div>

    <div class="col-sm-1">
        <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
        <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
        <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
        <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
    </div>

    <div class="col-sm-5">
        <select name="to[]" id="multiselect_to" class="form-control" size="8" multiple="multiple"></select>
    </div>
</div>
{{--
</div>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
--}}
{{ Form::bsSubmit('vai') }}
{{ Form::close() }}


<hr/>
@php
    $n_invii=0;
@endphp
<h3>invii effettuati</h3>
<table class="table table-striped table-bordered">
<tr>
<th>lavoratore</th>
<th>totale punteggio</th>
<th>numero invii</th>
<th>Dettaglio invii</th>
</tr>
@foreach($rows as $v)
<tr>
    <td>{{ $v->id }}] {{ $v->cognome }} {{ $v->nome }}
    <br/>{{ $v->email }}</td>
    <td>{{ $v->totale }}</td>
    <td>{{ $v->mailInviate->count() }}</td>
    @php
    if($v->mailInviate->count()>0){
        $n_invii++;
    }
    @endphp
    <td>
        <table class="table table-striped table-bordered">
        <tr>
            <th>data invio</th>
            <th>chi?</th>
            <th></th>

        </tr>
        @foreach($v->mailInviate as $vm)
        <tr>
            <td>{{ $vm->datemod }}</td>
            <td>{{ $vm->handle }}</td>
            <td>
                {{--
                {{ $vm->_data()['archivista_informatico'] }}
                {{ $vm->_data()['relazioni_pubblico'] }}
                {{ $vm->_data()['protezione_civile'] }}
                {{ $vm->_data()['formatore_professionale'] }}
                --}}
            </td>
        </tr>
        @endforeach
        </table>
    </td>
</tr>
@endforeach
</table>

<h3>totale da inviare : {{ $rows->count() }}<br/>
totale inviati : {{ $n_invii }}
</h3>



{{ Theme::addScript("/theme/bc/jquery/dist/jquery.min.js") }}
{{ Theme::addScript("/theme/bc/bootstrap/dist/js/bootstrap.min.js") }}
{{ Theme::addScript('/theme/bc/multiselect/dist/js/multiselect.js') }}

@endsection
@push('scripts')
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#multiselect').multiselect();
});
</script>
@endpush

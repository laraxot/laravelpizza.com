nds('adm_theme::layouts.app')
@section('page_heading','cerca')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


@if(isset($caption))
    {!! $caption !!}
@endif
{{--  Form::open(['route' => Request::route()->getName(),'method'=>'POST' ]) --}}

<?php
    // $routename=str_replace('.edit','.update',Request::route()->getName());
    $routename = Request::route()->getName();
$params = array_merge([$routename], getRouteParameters());
?>

{!! Form::model($row, ['route' => $params ]) !!}
{!! csrf_field() !!}
{{ method_field('POST') }}

@if(isset($stabi_opts))
{{ Form::bsSelect('stabi',null,['options'=>$stabi_opts]) }}
@else
{{ Form::bsSelect('stabi',null,['options'=>$row->stabi_opts()]) }}
@endif
{{ Form::bsSelect('repar') }}


{{ Form::bsText('anno') }}
{{ Form::bsSubmit('vai') }}


{!! Form::close() !!}
@endsection



<!--
https://gist.github.com/msurguy/5138788
https://github.com/dala00/jquery-hierselect
http://mansion.im/2011/twitter-bootstrap-and-the-quickform2-callback-renderer/

-->
@push('scripts')
<script>


$(document).ready(function($){
    $('#stabi').change(function(){
    var href="{{ url('api/getRepartsFromStabi') }}";
    $.get(href,
    { stabi: $(this).val() },
    function(data) {
    	//console.log(data);
        var model = $('#repar');
        model.empty();
        $.each(data, function(index, el) {
        	//console.log(el);
            model.append("<option value='"+ el.repar +"'>" + el.repar + '] '+el.dest1 + "</option>");
        });

    });
    });
});


</script>

@endpush

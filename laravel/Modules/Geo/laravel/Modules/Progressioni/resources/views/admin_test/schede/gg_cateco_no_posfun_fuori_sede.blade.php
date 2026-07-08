nds('adm_theme::layouts.app')
@section('page_heading','dettaglio')
@section('section')

<a class="btn btn-primary" href="{{ route('progressioni.stabi_repar_anno.schede.index',$params) }}"><i class="glyphicon glyphicon-step-backward"></i></a>
{{--
@include(str_replace('.schede.','.ctrlmatr.',$view ))
--}}
@endsection
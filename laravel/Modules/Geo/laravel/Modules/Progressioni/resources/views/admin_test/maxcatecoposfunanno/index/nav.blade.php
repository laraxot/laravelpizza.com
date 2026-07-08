<a class="btn btn-small btn-info"  data-toggle="tooltip" title="Torna alla ricerca" href="{{  route(str_replace('.stabi_repar_anno.','.',str_replace('.index','.searchStabiReparAnno',\Route::currentRouteName()))) }}"><i class="fa fa-step-backward fa-fw" aria-hidden="true"></i>&nbsp;</a>
--}}

<a class="btn btn-default" href="{{ route('progressioni.maxCatecoPosfunAnno') }}"><i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp; Torna alla ricerca</a>
<a class="btn btn-small btn-default" data-toggle="tooltip" title="Crea XLS" href="{{  route(str_replace('.index','.xls',\Route::currentRouteName()),$params) }}"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>&nbsp;</a>
<a class="btn btn-small btn-default" data-toggle="tooltip" title="Crea PDF riepilogo" href="{{  route(str_replace('.index','.pdf',\Route::currentRouteName()),$params) }}"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i>&nbsp;</a>
<a class="btn btn-small btn-default" data-toggle="tooltip" title="Crea ZIP delle schede pdf" href="{{  route(str_replace('.index','.pdfszip',\Route::currentRouteName()),$params) }}"><i class="fa fa-file-archive-o fa-fw" aria-hidden="true"></i>&nbsp;</a>
<a class="btn btn-small btn-default" data-toggle="tooltip" title="Filtro invia Mail" href="{{ route(str_replace('.index','.filtersendmail',\Route::currentRouteName()),$params) }}"><i class="fa fa-paper-plane-o fa-fw" aria-hidden="true"></i>&nbsp;</a>

{{--

--}}
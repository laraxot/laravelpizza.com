@php
    $view=str_replace('individuale-po.','individuale-dip.',$view);
@endphp
@include($view,['view'=>$view])


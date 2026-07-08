@php
    $view=str_replace('individuale-dirigente.','individuale-dip.',$view);
@endphp
@include($view,['view'=>$view])


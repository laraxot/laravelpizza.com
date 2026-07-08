    $view=str_replace('.update.','.show.',$view);
@endphp
@include($view,['view'=>$view])

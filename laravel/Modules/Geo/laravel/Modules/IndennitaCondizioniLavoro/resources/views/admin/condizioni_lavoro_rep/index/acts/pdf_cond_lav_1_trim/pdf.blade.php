    $view=str_replace('_1_trim','_trim',$view);
    $view=str_replace('_2_trim','_trim',$view);
    $view=str_replace('_3_trim','_trim',$view);
    $view=str_replace('_4_trim','_trim',$view);
    $view=str_replace('.update.','.show.',$view);
@endphp
@include($view,['view'=>$view])

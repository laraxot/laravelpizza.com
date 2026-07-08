    $view=str_replace('edit1_trim','edit_trim',$view);
    $view=str_replace('edit2_trim','edit_trim',$view);
    $view=str_replace('edit3_trim','edit_trim',$view);
    $view=str_replace('edit4_trim','edit_trim',$view);
    $view=str_replace('.update.','.show.',$view);
@endphp
@include($view,['view'=>$view])

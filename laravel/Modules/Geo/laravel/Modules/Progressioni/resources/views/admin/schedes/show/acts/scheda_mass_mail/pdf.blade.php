    $view=str_replace('.scheda_mass_mail.','.scheda_pdf.',$view);
@endphp
@include($view,['view'=>$view])

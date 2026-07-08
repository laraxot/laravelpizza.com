    if(!isset($year)){
        $year=date('Y');
    }
@endphp
@livewire('nav.stabi-repar-anno',['nav'=>$nav,'year'=>$year])

$rows->count() > 0)
    <table class="table table-bordered">
        <tr>
            <td><b>Eccellenze assegnate</b></td>
            <td align="right">{{ $rows->where('excellence', 1)->count() }}</td>
        </tr>
        {{-- <tr>
            <td><b>Eccellenze disponibili</b></td>
            <td align="right">{{ $rows[0]->totStabi->n_diritto_excellence }}</td>
        </tr> --}}
    </table>
    @livewire('edit-firma',['module_name'=>'performance'])

@endif

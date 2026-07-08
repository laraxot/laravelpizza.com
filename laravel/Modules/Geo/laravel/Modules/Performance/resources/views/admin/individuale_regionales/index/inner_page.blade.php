@endphp
@if ($rows->count() > 0)
    <table class="table table-bordered">
        <tr>
            <td><b>Eccellenze assegnate</b></td>
            <td align="right">{{ $rows->where('excellence', 1)->count() }}</td>
        </tr>
    </table>
@endif
@livewire('edit-firma',['module_name'=>'performance'])

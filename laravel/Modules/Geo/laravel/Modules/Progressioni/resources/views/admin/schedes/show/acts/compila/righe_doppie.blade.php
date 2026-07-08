eriodi</h4>
<table class="table bordered">
    @foreach($rows as $v)
        <tr>
            <td>
                {{ $v->id }}
            </td>
            <td>
                {{ $v->dal }} - {{ $v->al }}
            </td>
            <td>
                {{ $v->categoria_eco }}
            </td>
            <td>
                {{ $v->stabi }} {{ $v->stabi_txt }} <br/>
                {{ $v->repar }} {{ $v->repar_txt }}
            </td>
            <td>
                [{{ $v->valutatore->id }}] {{ $v->valutatore->nome_diri }}
            </td>
        </tr>
    @endforeach
</table>

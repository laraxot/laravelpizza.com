<table class="table">
    @foreach ($rows /*->where('ha_diritto',1)*/ as $v)
        <tr>
            <td>{{ $v->id }} <br /> {{ $v->cognome }} {{ $v->nome }} <br /> {{ $v->email }}</td>
            <td>
                @foreach ($v->mailInviate as $vm)
                    @if ($loop->first)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>data</th>
                                    <th>utente</th>
                                    {{-- <th>punt progressione</th>
							<th>punt progressione finale</th> --}}
                                </tr>
                            </thead>
                    @endif
        <tr>
            <td>{{ $vm->created_at }}</td>
            <td>{{ $vm->created_by }}</td>
            {{-- <td>{{ $vm->data['punt_progressione'] }}</td>
					<td>{{ $vm->data['punt_progressione_finale'] }}</td> --}}
        </tr>
        @if ($loop->last)
</table>
@endif
@endforeach

</td>
</tr>
@endforeach
</table>

    @php
    //dddx($select_opts);
    @endphp
    <form method="get">
  	<ul class="pagination justify-content-center">
		<li>
            <select class="form-control" name="stabi" wire:model="stabi" wire:change="setSubSelect()">
                <option value="" ></option>
                @foreach($select_opts as $k=>$v)
                <option value="{{ $v['id'] }}">{{ $v['label'] }}</option>
                @endforeach
            </select>
        </li>
        <li>
            <select class="form-control" name="repar" wire:model="repar">
                {{--
                <option value="" ></option>
                --}}
                @foreach($select_opt_subs as $k=>$v)
                <option value="{{ $v['id'] }}">{{ $v['label'] }}</option>
                @endforeach
            </select>
        </li>
        <li>
            <input type="text" name="year" wire:model="year" class="form-control" >
        </li>
        <li>
			<button type="submit" class="btn btn-info">
				<i class="fas fa-filter"></i>
			</button>
		</li>
      </ul>
    </form>
</div>

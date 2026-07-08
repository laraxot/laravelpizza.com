<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <div class="card-header">Personnel Management</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID<br />Handle</th>
                    <th>First Name<br />LastName</th>
                    <th>last </th>
                    {{-- <th>Actions <div class="badge bg-primary text-white rounded-pill">Full-time</div></th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($_theme->lastLoggedUsers(10) as $user)
                    <tr>
                        <td>{{ $user->id }}<br />{{ $user->handle }}</td>
                        <td>{{ $user->first_name }}<br />{{ $user->last_name }}</td>
                        <td>{{ $user->last_login_at }}<br />
                            {{ $user->last_login_ip }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

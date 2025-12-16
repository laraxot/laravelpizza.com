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
                @foreach (optional($_theme)->lastLoggedUsers(10) as $user)
                    <tr>
                        <td>{{ optional($user)->id }}<br />{{ optional($user)->handle }}</td>
                        <td>{{ optional($user)->first_name }}<br />{{ optional($user)->last_name }}</td>
                        <td>{{ optional($user)->last_login_at }}<br />
                            {{ optional($user)->last_login_ip }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

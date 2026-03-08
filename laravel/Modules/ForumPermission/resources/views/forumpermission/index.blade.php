@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Forum Permissions</h4>
                    <a href="{{ route('forum-permission.create') }}" class="btn btn-primary btn-sm float-right">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Forum</th>
                                    <th>Role</th>
                                    <th>Create Post</th>
                                    <th>Edit Post</th>
                                    <th>Delete Post</th>
                                    <th>Create Thread</th>
                                    <th>Edit Thread</th>
                                    <th>Delete Thread</th>
                                    <th>Reply</th>
                                    <th>Edit Reply</th>
                                    <th>Delete Reply</th>
                                    <th>Moderate</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forumPermissions as $forumPermission)
                                <tr>
                                    <td>{{ $forumPermission->id }}</td>
                                    <td>{{ $forumPermission->name }}</td>
                                    <td>{{ $forumPermission->forum->name ?? 'N/A' }}</td>
                                    <td>{{ $forumPermission->role->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($forumPermission->can_create_post)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($forumPermission->can_edit_post)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($forumPermission->can_delete_post)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($forumPermission->can_create_thread)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($forumPermission->can_edit_thread)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($forumPermission->can_delete_thread)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($forumPermission->can_reply)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($forumPermission->can_edit_reply)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($forumPermission->can_delete_reply)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($forumPermission->can_moderate)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('forum-permission.show', $forumPermission->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('forum-permission.edit', $forumPermission->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('forum-permission.destroy', $forumPermission->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $forumPermissions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
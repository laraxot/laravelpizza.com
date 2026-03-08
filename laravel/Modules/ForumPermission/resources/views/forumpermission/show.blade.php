@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Forum Permission Details</h4>
                    <a href="{{ route('forum-permission.index') }}" class="btn btn-secondary btn-sm float-right">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $forumPermission->id }}</p>
                            <p><strong>Name:</strong> {{ $forumPermission->name }}</p>
                            <p><strong>Forum:</strong> {{ $forumPermission->forum->name ?? 'N/A' }}</p>
                            <p><strong>Role:</strong> {{ $forumPermission->role->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Created At:</strong> {{ $forumPermission->created_at ? $forumPermission->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                            <p><strong>Updated At:</strong> {{ $forumPermission->updated_at ? $forumPermission->updated_at->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                    @if($forumPermission->description)
                        <div class="mt-3">
                            <h5>Description:</h5>
                            <div class="border p-3 bg-light">
                                {!! $forumPermission->description !!}
                            </div>
                        </div>
                    @endif
                    <div class="mt-3">
                        <h5>Permissions:</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Permission</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Create Post</td>
                                        <td>
                                            @if($forumPermission->can_create_post)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Edit Post</td>
                                        <td>
                                            @if($forumPermission->can_edit_post)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Delete Post</td>
                                        <td>
                                            @if($forumPermission->can_delete_post)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Create Thread</td>
                                        <td>
                                            @if($forumPermission->can_create_thread)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Edit Thread</td>
                                        <td>
                                            @if($forumPermission->can_edit_thread)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Delete Thread</td>
                                        <td>
                                            @if($forumPermission->can_delete_thread)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Reply</td>
                                        <td>
                                            @if($forumPermission->can_reply)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Edit Reply</td>
                                        <td>
                                            @if($forumPermission->can_edit_reply)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Delete Reply</td>
                                        <td>
                                            @if($forumPermission->can_delete_reply)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Moderate</td>
                                        <td>
                                            @if($forumPermission->can_moderate)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('forum-permission.edit', $forumPermission->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('forum-permission.destroy', $forumPermission->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
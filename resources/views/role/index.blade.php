@extends('layouts.admin')

@section('title')
Roles
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex align-items-end">
        <h3 class="card-title">@yield('title') Table</h3>

        <div class="card-tools ml-auto">
            <a href="{{route('role.create')}}" class="btn btn-primary">Create New Role</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role</th>
                    <th>Permission</th>
                    <th>Action</th>
                    <th>Date Posted</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)

                <tr>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                        @forelse ($role->permissions as $permission)
                        <button class="btn btn-warning"><i class="fas fa-shield-alt">&nbsp;{{$permission->name}}</i></button>
                        @empty
                        <button class="btn btn-warning"><i class="fas fa-shield-alt">&nbsp;No Role</i></button>
                        @endforelse

                    </td>
                    <td>
                        <a href="{{route('role.edit',$role->id)}}" class="btn btn-sm btn-warning">Edit
                            Permission</a>
                        <button data-toggle="modal" data-target="#modal-delete" data-target-id="{{ $role->id }}"
                            class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>&nbsp; Delete</button>
                    </td>

                    <td><span class="log log-success">{{$role->updated_at}}</span></td>

                </tr>

                @empty
                <tr>
                    <td> <span class="tag tag-success"><i class="fas fa-folder-open"></i> No Record Found</span> </td>
                </tr>

                @endforelse

            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>


<div class="modal fade" id="modal-delete" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Default Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="delete-modal modal-body d-flex flex-direction-row justify-content-between align-items-center">
                <p><i class="fas fa-exclamation fa-2x border p-5"></i></p>
                <p>Are you sure to delete that user</p>
            </div>
            <div class="modal-footer justify-content-center">
                <form id="deleteRoleForm" action="" method="POST">
                    @csrf
                    {{method_field('DELETE')}}
                    <button id="deleteRoleButton" type="sumbit" class="btn btn-primary">Delete</button>
                </form>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


@push('scripts')
<script>
    window.addEventListener('DOMContentLoaded', function() { 
       
            $("#modal-delete").on("show.bs.modal", function (e) {
                 var id = $(e.relatedTarget).data('target-id');
                 var url = '{{ route("role.destroy", ":id") }}';
                 url = url.replace(':id', id);
                 $("#deleteRoleForm").attr("action",url);                                                          
            }); 
            
    });

</script>
@endpush
@endsection
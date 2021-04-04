@extends('layouts.admin')

@section('title')
Permissions
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex align-items-end">
        <h3 class="card-title">Standart @yield('title') Table</h3>

        <div class="card-tools ml-auto">
            <a href="{{route('permission.create')}}" class="btn btn-primary">Create New Standart Permission</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date Posted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($standartPermissions as $permission)

                <tr>
                    <td>{{$permission->id}}</td>
                    <td>{{$permission->name}}</td>
                    <td>{{$permission->updated_at}}</td>
                    <td>
                        <button data-toggle="modal" data-target="#modal-delete" data-target-id="{{ $permission->id }}"
                            class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>&nbsp; Delete</button>
                    </td>

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

<div class="card">
    <div class="card-header d-flex align-items-end">
        <h3 class="card-title">WildCard @yield('title') Table</h3>

        <div class="card-tools ml-auto">
            <a href="{{route('permission.create')}}" class="btn btn-primary">Create New Wildcard Permission</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date Posted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($wildCardParent as $permission)

                <tr>
                    <td>{{$permission->id}}</td>
                    <td>{{$permission->name}}</td>
                    <td>{{$permission->updated_at}}</td>
                    <td>
                        <button data-toggle="modal" data-target="#modal-delete" data-target-id="{{ $permission->id }}"
                            class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>&nbsp; Delete</button>
                    </td>

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
                <form id="deletePermissionForm" action="" method="POST">
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
                 var url = '{{ route("permission.destroy", ":id") }}';
                 url = url.replace(':id', id);
                 $("#deletePermissionForm").attr("action",url);
            });

    });

</script>
@endpush
@endsection

@extends('layouts.admin')

@section('title')
Users
@endsection
@section('content')


<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title my-auto">@yield('title') Table</h3>


        <ul class="nav nav-pills ml-auto">
            <li class="nav-item mr-1">
                <a href="{{route('user.create')}}" class="btn btn-sm btn-primary"><i
                        class="fas fa-plus-circle"></i>&nbsp;Create New User</a>
            </li>
        </ul>

    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-3">
        <table id="table-user" class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Action</th>
                    <th>Date Posted</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($users as $user)

                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>
                        <button class="btn btn-warning"><i class="fas fa-shield-alt">&nbsp;{{$user->role}}</i></button>
                    </td>
                    <td>{{$user->email}}</td>
                    <td>
                        <button data-toggle="modal" data-target="#modal-default" data-target-id="{{ $user->id }}"
                            class="btn btn-sm btn-info viewbutton"><i class="fas fa-eye"></i>&nbsp; View</button>
                        <a href="{{route('user.edit', $user->id)}}" class="btn btn-sm btn-warning"><i
                                class="fas fa-edit"></i>&nbsp; Edit</a>
                        @can("create-user", Model::class)
                        <button data-toggle="modal" data-target="#modal-delete" data-target-id="{{ $user->id }}"
                            class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>&nbsp; Delete</button>
                        @endcan
                    </td>
                    <td><span class="log log-success">{{$user->updated_at}}</span></td>

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

<div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-6">
                        <p id="modalName"><b>Name:</b></p>
                        <p id="modalEmail"><b>Email:</b> </p>
                        <p id="modalDateU"><b>Last Updated:</b> </p>
                        <p id="modalDateP"><b>Date Posted:</b> </p>
                        {{-- <input type="text" id="pass_id"> --}}
                    </div>

                    <div class="col-md-6">
                        <img id="modalDateImage" src="" class="img-circle">
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
                <form id="deleteUserForm" action="" method="POST">
                    @csrf
                    {{method_field('DELETE')}}
                    <button id="deleteUserButton" type="sumbit" class="btn btn-primary">Delete</button>
                </form>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection


@push('scripts')
<script>
    window.addEventListener('DOMContentLoaded', function() {
        $('#table-user').DataTable();

          $("#modal-default").on("show.bs.modal", function (e) {
                 var id = $(e.relatedTarget).data('target-id');

                $.ajax({
                    url: "/getUserModalData",
                    type: "get",
                    data: {"id": id},
                    success:function(result){

                        var dateUpdatedAt = new Date(result.user.updated_at);
                        var dateCreatedAt = new Date(result.user.created_at);
                        dateUpdatedAt =  dateFormat(dateCreatedAt);
                        dateCreatedAt = dateFormat(dateCreatedAt);

                        $('#modalName').html("<b>Name:&nbsp;</b>"+result.user.name);
                        $('#modalEmail').html("<b>Email:&nbsp;</b>" +result.user.email);
                        $('#modalDateU').html("<b>Last Updated:&nbsp;</b>" +dateUpdatedAt);
                        $('#modalDateP').html("<b>Post dated:&nbsp;</b>" + dateCreatedAt);

                        var src = '{{asset("img/adminlte/:photo")}}';
                        src = src.replace(':photo',result.user.photo);
                        $("#modalDateImage").attr("src",src);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    }
                });

            });
            $("#modal-delete").on("show.bs.modal", function (e) {
                 var id = $(e.relatedTarget).data('target-id');
                 var url = '{{ route("user.destroy", ":id") }}';
                 url = url.replace(':id', id);
                 $("#deleteUserForm").attr("action",url);

            });


    });

</script>
@endpush

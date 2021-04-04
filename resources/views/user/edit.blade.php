@extends('layouts.admin')

@section('title')
Update The User
@endsection
@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit The User</h3>
        <div class="card-tools">
            <a href="{{ route('user.index') }}" class="btn btn-danger"><i class="fas fa-shield-alt"></i> See All
                Users</a>
        </div>
    </div>
    <form method="POST" action="{{route('user.update',$user->id)}}">
        @csrf
        {{method_field('PUT')}}
        <div class="modal-body">
            <div class="row">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" placeholder="User Name" class="form-control"
                            value="{{$user->name}}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="phone" placeholder="Phone Number" class="form-control"
                            value="{{$user->phone}}" required>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="Email" name="email" placeholder="Email" class="form-control"
                            value="{{$user->email}}" required>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="Password" name="password" placeholder="Password" class="form-control"
                             >
                    </div>
                </div>

                <div class="col-sm-6 ">
                    <!-- select -->
                    <div class="form-group">
                        <label>Choose Role</label>
                        <select name="role" class="form-control">
                            @forelse ($roles as $role)
                            <option value="{{$role->name}}"
                                {{($role->name == $user->role) ? ' selected="selected"' : ''}}>{{$role->name}}</option>
                                @empty
                                Any role is not there
                            @endforelse

                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group" id="formgroup">

                        <label tabindex="-1" class="bv-no-focus-ring col-form-label pt-0" id="assign">Assign
                            Permissions</label>
                        <div class="d-flex flex-wrap">
                            @forelse ($permissions as $permission)

                            <div class="custom-control custom-checkbox m-0 col-sm-12 col-md-6">
                                <input type="checkbox" name="permissions[]" class="custom-control-input"
                                    value="{{$permission->name}}" id="{{$permission->id}}"
                                    {{  (in_array($permission->name,$user->permissions->toArray()) ? 'checked' : '')}}>
                                <label class="custom-control-label" for="{{$permission->id}}">
                                    {{$permission->name}}
                                </label>
                            </div>
                            @empty
                            Any Permission not there   
                            
                            @endforelse


                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="modal-footer justify-content-between">
            <button type="submit" class="btn btn-lg btn-primary">
                <i class="fas fa-save"></i> Update User </button>
        </div>
    </form>
</div>
@endsection
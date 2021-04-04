@extends('layouts.admin')

@section('title')
Create Role
@endsection
@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Role</h3>
        <div class="card-tools">
            <a href="{{ route('role.index') }}" class="btn btn-danger"><i class="fas fa-shield-alt"></i> See All
                Roles</a>
        </div>
    </div>
    <form method="POST" action="{{route('role.store')}}">
        @csrf
        <div class="modal-body">
            <div class="form-group"><input type="text" name="name" placeholder="Role Name" class="form-control">
                <!---->
            </div>
            <fieldset class="form-group" id="formgroup">
                <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0" id="assign">Assign
                    Permissions</legend>
                <div>
                    @foreach ($permissions as $permission)
                          <div class="custom-control custom-checkbox"><input type="checkbox" name="permissions[]"
                            class="custom-control-input" value="{{$permission->name}}" id="{{$permission->id}}"><label
                            class="custom-control-label" for="{{$permission->id}}">
                            {{$permission->name}}
                        </label></div>
                    @endforeach
                  
                                  
                </div>
            </fieldset>
        </div>
        <div class="modal-footer justify-content-between">
            <!----> <button type="submit" class="btn btn-lg btn-primary"><i class="fas fa-save"></i> Save Role
            </button></div>
    </form>
</div>
@endsection
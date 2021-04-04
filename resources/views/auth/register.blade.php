@extends('layouts.app')

@section('content')
<div class="register-box">
    <div class="register-logo text-white">
        <h1><b>{{__('Website Name')}}</b></h1>
        <h2> {{__('Vizyoner Managment Panel')}}</h2>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">{{__('Register a new membership')}}</p>

            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus
                        placeholder="{{__('Full name')}}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" placeholder="{{__('Email')}}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert"> 
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        required autocomplete="new-password" placeholder="{{__('Password')}}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password_confirmation" required
                        autocomplete="new-password" placeholder="{{__('Retype password')}}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">               
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">{{__('Register')}}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="{{route('login')}}" class="text-center">{{__('I already have a membership')}}</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>


@endsection
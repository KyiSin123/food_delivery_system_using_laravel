@extends('layouts.app')

@section('content')
    <div class="login-form p-5 my-5 border shadow rounded">
        <h2>Login</h2>
        <form method="POST" action="{{ route('admins.login') }}">
            @csrf
            <div class="my-3">
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <label for="email" class="form-label"> Email: </label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                    placeholder="Enter your email (example@gmail.com)" value="{{ old('email') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong> {{ $message }} </strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"> Password: </label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    id="password" placeholder="Enter Password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong> {{ $message }} </strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn login"> Login </button>
        </form>
    </div>
@endsection

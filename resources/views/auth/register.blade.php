@extends('layouts.app')

@section('content')
<div class="register-form p-5 my-5 border shadow rounded">
        <h2> Sign Up </h2>
        <form method="POST" action="{{ route('register') }}" autocomplete="off">
            @csrf
        <div class="row">
            <div class="col-6">
                <div class="my-3">
                    <label for="name" class="form-label"> Name: </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter your name" 
                    name="name" value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong> {{ $message }} </strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="my-3">
                    <label for="email" class="form-label"> Email: </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                        id="email" placeholder="Enter your email (example@gmail.com)" name="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong> {{ $message }} </strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="password" class="form-label"> Password: </label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                        id="password" placeholder="Enter password" name="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong> {{ $message }} </strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="confirm-password" class="form-label"> Comfirm Password: </label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                        id="confirm-password" placeholder="Confirm your password" name="password_confirmation">
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong> {{ $message }} </span>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn mt-2 login"> Sign Up </button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="post-form p-5">
        <div class="col-6 post-create">
            <div class="card p-5 shadow">
                <h2 class="create-post">Add New Menu:</h2>
                <form method="POST" action="{{ route('menus.create', $shop->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="my-3">
                        <label for="menu-name" class="form-label"> Menu Name: </label>
                        <input type="text" class="form-control @error('menu_name') is-invalid @enderror" id="menu-name" name="menu_name" 
                            value="{{ old('menu_name') }}">
                        @error('menu_name')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label"> Description for your menu: </label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            value="{{ old('description') }}">
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label"> Price: </label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                            value="{{ old('price') }}">
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-field mb-4">
                        <label for="image" class="form-label">Add your menu photo:</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn shop-register-btn w-100 text-white">ADD</button>
                </form>
            </div>
        </div>
    </div>
@endsection
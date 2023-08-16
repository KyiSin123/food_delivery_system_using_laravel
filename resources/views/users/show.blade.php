@extends('layouts.app')

@section('styles')
    <style>
        h3{
            color: #fa5772;
        }
        .height {
            height: 119px;
        }
        .my-profile {
            margin: 0 auto;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-12 my-profile my-5">
            <div class="card p-4">
                <div class="row justify-content-end mb-3">
                    <div class="col-1">
                        <a href="{{ route('home') }}">
                            <div class="btn btn-close float-end" aria-label="Close">
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-4">
                        <h3> My Profile </h3>
                    </div>
                    <div class="col-8">
                        <a onclick="editUser({{ $user }})" class="btn profile-edit mb-2" type="button"><i class="fas fa-edit"></i> Edit</a>
                        <a onclick="changePassword()" class="btn btn-secondary" > <i class="fa-solid fa-key"></i> Change Password </a>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row mt-4">
                    <div class="col-4"> 
                        <label for="name" > User Name: </label>
                    </div>
                    <div class="col-8"> 
                        <input type="text" id="name" value="{{ $user->name }}" disabled class="form-control"> 
                    </div>
                </div>
                <div class="row mt-3 mb-5">
                    <div class="col-4"> 
                        <label for="ph-number" > Email Address: </label> 
                    </div>
                    <div class="col-8"> 
                        <input type="text" id="ph_number" value="{{ $user->email }}" disabled class="form-control">
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="editUserForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="edit-user" autocomplete="off">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mt-4">
                                        <div class="alert alert-danger print-error-msg" style="display:none">
                                            <ul class="text-center"></ul>
                                        </div>
                                        <div class="col-4"> 
                                            <label for="user_name" > User Name: </label>
                                        </div>
                                        <div class="col-8"> 
                                            <input type="text" id="user_name" class="form-control" name="name"> 
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4"> 
                                            <label for="email" > Email Address: </label> 
                                        </div>
                                        <div class="col-8"> 
                                            <input type="text" id="email" class="form-control" name="email">
                                        </div>
                                    </div>
                                    <div class="mt-4 text-end">
                                        <button type="button" id="update-btn" onclick="updateUser({{$user}})"  class="btn profile-edit">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editPasswordForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="change-password" autocomplete="off">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mt-4">
                                        <div class="alert alert-danger print-error-msg" style="display:none">
                                            <ul class="text-center"></ul>
                                        </div>
                                        <div class="col-4"> 
                                            <label for="current_password" > Current Password: </label>
                                        </div>
                                        <div class="col-8"> 
                                            <input type="password" id="current_password" class="form-control" name="current_password"> 
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4"> 
                                            <label for="new-password"> New Password: </label> 
                                        </div>
                                        <div class="col-8"> 
                                            <input type="password" id="new-password" class="form-control" name="new_password">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4"> 
                                            <label for="password-comfirmation" > Retype New Password: </label> 
                                        </div>
                                        <div class="col-8"> 
                                            <input type="password" id="password-confirmation" class="form-control" name="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="mt-4 text-end">
                                        <button type="button" onclick="updatePassword({{$user}})"  class="btn profile-edit">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function editUser(user) {
        $('#user_name').val(user.name);
        $('#email').val(user.email);
        $('#editUserForm').modal('show');
    }

    function updateUser(user) {
        var url = '{{ route("users.update", request('id')) }}';
        $.ajax({
            type: "PUT",
            url: url,
            data: $('#edit-user').serialize(),
            dataType: 'json',
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $('#editUserForm').modal('hide');
                    window.location.reload();
                } else {
                    printErrorMsg(data.error);
                }
            }
        });
    }

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }

    function changePassword() {
        $('#editPasswordForm').modal('show');
    }

    function updatePassword(user) {
        var url = '{{ route("users.changePassword", request('id')) }}';
        $.ajax({
            type: "PUT",
            url: url,
            data: $('#change-password').serialize(),
            dataType: 'json',
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    alert(data.message);
                    $('#editPasswordForm').modal('hide');
                    window.location.reload();
                } else {
                    printErrorMsg(data.error);
                }
            }
        })
    }
</script>
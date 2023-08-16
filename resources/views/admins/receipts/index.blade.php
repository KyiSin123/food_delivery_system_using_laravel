@extends('admins.adminLte')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-end pt-4">
        <div class="col-3">
            <form>
                <div class="input-group input-group">
                    <input class="form-control float-right" name="search" type="search"
                            value="{{ request('search') }}" placeholder="Search">

                    <div class="input-group-append">
                        <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Shop Name</th>
                                <th>Menus</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->shop->name }}</td>
                                    <td>
                                        @foreach($order->menus as $menu)
                                            {{ $menu->name }} |
                                        @endforeach
                                    </td>
                                    <td>{{ $order->total_price }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="12">No order yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($orders->hasPages())
                    <!-- /.card-body -->
                    <div class="card-footer">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->

    <!-- Modal -->
    <div class="modal fade" id="admin-create" data-bs-backdrop="static" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Create Admin
                    </h5>
                    <button class="close closeId" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createForm" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul class="text-center"></ul>
                            </div>
                            <label for="name" class="form-label"> Name: </label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"> Email: </label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"> Password: </label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label"> Confirm Password: </label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button class="btn btn-outline-secondary closeId" type="button">Close</button>
                        <button class="btn btn-primary" type="submit" id="create">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="admin-edit" data-bs-backdrop="static" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Edit Admin
                    </h5>
                    <button class="close closeId" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul class="text-center"></ul>
                            </div>
                            <input type="hidden" name="adminId" id="adminId">
                            <label for="adminName" class="form-label"> Name: </label>
                            <input type="text" class="form-control" id="adminName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="adminEmail" class="form-label"> Email: </label>
                            <input type="text" class="form-control" id="adminEmail" name="email">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button class="btn btn-outline-secondary closeId" type="button">Close</button>
                        <button class="btn btn-primary" type="submit" id="update">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function create() {
        $('#admin-create').modal('show');
    }

    $('#createForm').submit(function(e) {
        e.preventDefault();
        var url = '{{ route("admins.adminUsers.create") }}';
        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $('#menu-create').modal('hide');
                    window.location.reload();
                } else {
                    printErrorMsg(data.error);
                }
            }
        })
    });

    function edit(admin) {
        console.log('haha');
        $('#adminId').val(admin.id);
        $('#adminName').val(admin.name);
        $('#adminEmail').val(admin.email);
        $('#admin-edit').modal('show');
    }

    $('#editForm').submit(function(e) {
        e.preventDefault();
        var id = $(this).find("input[name='adminId']").val();
        var url = '{{ route("admins.adminUsers.update", ":id") }}';
        url = url.replace(':id', id);
        $.ajax({
            type: "PUT",
            url: url,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $('#menu-edit').modal('hide');
                    window.location.reload();
                } else {
                    printErrorMsg(data.error);
                }
            }
        })
    });

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li class="style">' + value + '</li>');
        });
    }

    $('.closeId').click(function() {
        $('#admin-edit').modal('hide');
        $('#admin-create').modal('hide');
        $(".print-error-msg").css('display', 'none');
    })

</script>
@endsection